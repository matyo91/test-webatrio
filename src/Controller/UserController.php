<?php

namespace App\Controller;

use App\Dto\JobCreateDto;
use App\Dto\JobListDto;
use App\Dto\UserCreateDto;
use App\Entity\Job;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository
    )
    {
        
    }

    #[Route('/api/user', name: 'app_user', methods: ['POST'])]
    public function userCreate(
        #[MapRequestPayload] UserCreateDto $userCreate,
    ): Response
    {
        $user = new User();
        $user->setName($userCreate->name);
        $user->setFirstname($userCreate->firstname);
        $user->setBirthdate($userCreate->birthdate);

        $this->em->persist($user);
        $this->em->flush();

        return $this->json(true);
    }

    #[Route('/api/user/{user_id}/job', name: 'app_job', methods: ['POST'])]
    public function jobCreate(
        #[MapEntity(id: 'user_id')] User $user,
        #[MapRequestPayload] JobCreateDto $jobCreate,
    ): Response
    {
        $job = new Job();
        $job->setCompany($jobCreate->company);
        $job->setRole($jobCreate->role);
        $job->setDateBegin($jobCreate->dateBegin);
        $job->setDateEnd($jobCreate->dateEnd);

        $user->addJob($job);
        
        $this->em->persist($user);
        $this->em->flush();

        return $this->json(true);
    }

    #[Route('/api/users', name: 'list_users', methods: ['GET'])]
    public function listUsers(): Response
    {
        $users = $this->userRepository->findUsersSortedByName();

        $users = array_map(function(User $user) {
            $currentDate = date('Y-m-d');

            $lastJob = null;
            foreach($user->getJobs() as $job) {
                if(is_null($lastJob) || ($job->getDateEnd() !== null && $job->getDateEnd() > $lastJob['date_end'])) {
                    $lastJob = [
                        'date_end' => $job->getDateEnd(),
                        'role' => $job->getRole(),
                    ];
                }
            }

            return [
                'firstname' => $user->getFirstname(),
                'name' => $user->getName(),
                'age' => date_diff($user->getBirthdate(), date_create($currentDate))->y,
                'job' => is_null($lastJob) ? '' : $lastJob['role'],
            ];
        }, $users);

        return $this->json($users);
    }

    #[Route('/api/users/list_from_company/{company}', name: 'list_from_company', methods: ['GET'])]
    public function listFromCompany($company): Response
    {
        $users = $this->userRepository->findUsersByCompany($company);

        $users = array_map(function(User $user) {
            return [
                'firstname' => $user->getFirstname(),
                'name' => $user->getName(),
            ];
        }, $users);

        return $this->json($users);
    }

    #[Route('/api/user/{user_id}/jobs', name: 'app_jobs', methods: ['POST'])]
    public function listJobs(
        #[MapEntity(id: 'user_id')] User $user,
        #[MapRequestPayload] JobListDto $jobListDto
    ): Response
    {
        $jobs = array_filter($user->getJobs()->toArray(), function(Job $job) use ($jobListDto) {
            return $job->getDateBegin() > $jobListDto->dateBegin;
        });
        $jobsList = [];
        foreach($jobs as $job) {
            $jobsList[] = $job->getRole();
        }
        $jobsList = array_unique($jobsList);

        return $this->json($jobsList);
    }
}
