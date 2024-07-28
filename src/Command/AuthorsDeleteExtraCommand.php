<?php

namespace App\Command;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'authors:delete-extra',
    description: 'Remove authors who has no books written',
)]
class AuthorsDeleteExtraCommand extends Command
{
    public function __construct(
        public EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $extraUsers = $this->entityManager->getRepository(Author::class)->findAllExtra();

        if (!$extraUsers) {
            $io->success('No extra authors to delete!');
            return Command::SUCCESS;
        }

        foreach ($extraUsers as $user) {
            $this->entityManager->remove($user);
            $io->note(sprintf('Deleting user with id: %s...', $user->getId()));
        }
        
        $this->entityManager->flush();

        $io->success('Authors with no books has been deleted successfully!');
        return Command::SUCCESS;
    }
}
