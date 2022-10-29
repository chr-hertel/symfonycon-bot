<?php

namespace App\DataFixtures;

use App\Entity\Slot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $day = $this->loadDayOne();
        foreach ($day as $slot) {
            $manager->persist($slot);
        }
        $manager->flush();

        $day = $this->loadDayTwo();
        foreach ($day as $slot) {
            $manager->persist($slot);
        }
        $manager->flush();
    }

    /**
     * @return array<Slot>
     */
    private function loadDayOne(): array
    {
        return [
            new Slot('Badge pickup and welcome light breakfast ☕🥐', $this->newParisTime('11/21/19 8:00'), $this->newParisTime('11/21/19 9:00')),
            new Slot('🎉 Opening / Welcome session 👋', $this->newParisTime('11/21/19 9:00'), $this->newParisTime('11/21/19 9:15')),
            new Slot('Keynote', $this->newParisTime('11/21/19 9:15'), $this->newParisTime('11/21/19 9:55'), 'Fabien Potencier'),

            new Slot('HTTP/3: It\'s all about the transport!', $this->newParisTime('11/21/19 10:05'), $this->newParisTime('11/21/19 10:45'), 'Benoit Jacquemont', 'Advanced'),
            new Slot('How to contribute to Symfony and why you should give it a try', $this->newParisTime('11/21/19 10:05'), $this->newParisTime('11/21/19 10:45'), 'Valentin Udaltsov', 'Beginner'),
            new Slot('A view in the PHP Virtual Machine', $this->newParisTime('11/21/19 10:05'), $this->newParisTime('11/21/19 10:45'), 'Julien Pauli', 'PHP'),

            new Slot('Break ☕ 🥐', $this->newParisTime('11/21/19 10:45'), $this->newParisTime('11/21/19 11:15')),

            new Slot('How Doctrine caching can skyrocket your application', $this->newParisTime('11/21/19 11:15'), $this->newParisTime('11/21/19 11:55'), 'Jachim Coudenys', 'Advanced'),
            new Slot('Using the Workflow component for e-commerce', $this->newParisTime('11/21/19 11:15'), $this->newParisTime('11/21/19 11:55'), 'Michelle Sanver', 'Beginner'),
            new Slot('Crazy Fun Experiments with PHP (Not for Production)', $this->newParisTime('11/21/19 11:15'), $this->newParisTime('11/21/19 11:55'), 'Zan Baldwin', 'PHP'),

            new Slot('Lunch', $this->newParisTime('11/21/19 12:00'), $this->newParisTime('11/21/19 13:30')),

            new Slot('Hexagonal Architecture with Symfony', $this->newParisTime('11/21/19 13:30'), $this->newParisTime('11/21/19 14:10'), 'Matthias Noback', 'Advanced'),
            new Slot('Crawling the Web with the New Symfony Components', $this->newParisTime('11/21/19 13:30'), $this->newParisTime('11/21/19 14:10'), 'Adiel Cristo', 'Beginner'),
            new Slot('Adding Event Sourcing to an existing PHP project (for the right reasons)', $this->newParisTime('11/21/19 13:30'), $this->newParisTime('11/21/19 14:10'), 'Alessandro Lai', 'PHP'),

            new Slot('HYPErmedia: leveraging HTTP/2 and Symfony for better and faster web APIs', $this->newParisTime('11/21/19 14:20'), $this->newParisTime('11/21/19 15:00'), 'Kévin Dunglas', 'Advanced'),
            new Slot('PHP, Symfony and Security', $this->newParisTime('11/21/19 14:20'), $this->newParisTime('11/21/19 15:00'), 'Diana Ungaro Arnos', 'Beginner'),
            new Slot('What happens when you press enter?', $this->newParisTime('11/21/19 14:20'), $this->newParisTime('11/21/19 15:00'), 'Tobias Sjösten', 'PHP'),

            new Slot('Break ☕ 🥐', $this->newParisTime('11/21/19 15:00'), $this->newParisTime('11/21/19 15:30')),

            new Slot('Configuring Symfony - from localhost to High Availability', $this->newParisTime('11/21/19 15:30'), $this->newParisTime('11/21/19 16:10'), 'Nicolas Grekas', 'Advanced'),
            new Slot('HTTP Caching with Symfony 101', $this->newParisTime('11/21/19 15:30'), $this->newParisTime('11/21/19 16:10'), 'Matthias Pigulla', 'Beginner'),
            new Slot('How fitness helps you become a better developer', $this->newParisTime('11/21/19 15:30'), $this->newParisTime('11/21/19 16:10'), 'Magnus Nordlander', 'PHP'),

            new Slot('Meet the Core Team - Roundtable', $this->newParisTime('11/21/19 16:20'), $this->newParisTime('11/21/19 17:00')),

            new Slot('Social event (drinks and snacks)', $this->newParisTime('11/21/19 18:00'), $this->newParisTime('11/21/19 21:00')),
        ];
    }

    /**
     * @return array<Slot>
     */
    private function loadDayTwo(): array
    {
        return [
            new Slot('Light breakfast ☕🥐', $this->newParisTime('11/22/19 8:00'), $this->newParisTime('11/22/19 9:00')),
            new Slot('PHPUnit Best Practices', $this->newParisTime('11/22/19 9:00'), $this->newParisTime('11/22/19 9:40'), 'Sebastian Bergmann'),

            new Slot('Using API Platform to build ticketing system', $this->newParisTime('11/22/19 09:50'), $this->newParisTime('11/22/19 10:30'), 'Antonio Peric-Mazar', 'Advanced'),
            new Slot('Make the Most out of Twig', $this->newParisTime('11/22/19 09:50'), $this->newParisTime('11/22/19 10:30'), 'Andrii Yatsenko', 'Beginner'),
            new Slot('Mental Health in the Workplace', $this->newParisTime('11/22/19 09:50'), $this->newParisTime('11/22/19 10:30'), 'Stefan Koopmanschap', 'PHP'),

            new Slot('Break ☕ 🥐', $this->newParisTime('11/22/19 10:30'), $this->newParisTime('11/22/19 11:00')),

            new Slot('Importing bad data - Outputting good data with Symfony', $this->newParisTime('11/22/19 11:00'), $this->newParisTime('11/22/19 11:40'), 'Michelle Sanver', 'Advanced'),
            new Slot('Symfony Serializer: There and back again', $this->newParisTime('11/22/19 11:00'), $this->newParisTime('11/22/19 11:40'), 'Juciellen Cabrera', 'Beginner'),
            new Slot('Eeek, my tests are mutating!', $this->newParisTime('11/22/19 11:00'), $this->newParisTime('11/22/19 11:40'), 'Lander Vanderstraeten', 'PHP'),

            new Slot('Integrating performance management in your development cycle', $this->newParisTime('11/22/19 11:50'), $this->newParisTime('11/22/19 12:30'), 'Marc Weistroff', 'Advanced'),
            new Slot('Demystifying React JS for Symfony developers', $this->newParisTime('11/22/19 11:50'), $this->newParisTime('11/22/19 12:30'), 'Titouan Galopin', 'Beginner'),
            new Slot('Head first into Symfony Cache, Redis & Redis Cluster', $this->newParisTime('11/22/19 11:50'), $this->newParisTime('11/22/19 12:30'), 'Andre Rømcke', 'PHP'),

            new Slot('Lunch', $this->newParisTime('11/22/19 12:30'), $this->newParisTime('11/22/19 14:00')),

            new Slot('Prime Time with Messenger: Queues, Workers & more Fun!', $this->newParisTime('11/22/19 14:00'), $this->newParisTime('11/22/19 14:40'), 'Ryan Weaver', 'Advanced'),
            new Slot('SymfonyCloud: the infrastructure of the Symfony ecosystem', $this->newParisTime('11/22/19 14:00'), $this->newParisTime('11/22/19 14:40'), 'Tugdual Saunier', 'Beginner'),
            new Slot('Together towards an AI, NEAT plus ultra', $this->newParisTime('11/22/19 14:00'), $this->newParisTime('11/22/19 14:40'), 'Grégoire Hébert', 'PHP'),

            new Slot('Building really fast applications', $this->newParisTime('11/22/19 14:50'), $this->newParisTime('11/22/19 15:30'), 'Tobias Nyholm', 'Advanced'),
            new Slot('Everything you wanted to know about Sylius, but didn’t find time to ask', $this->newParisTime('11/22/19 14:50'), $this->newParisTime('11/22/19 15:30'), 'Łukasz Chruściel', 'Beginner'),
            new Slot('DevCorp: Choose Your Own Adventure', $this->newParisTime('11/22/19 14:50'), $this->newParisTime('11/22/19 15:30'), 'Pauline Vos', 'PHP'),

            new Slot('Break ☕ 🥐', $this->newParisTime('11/22/19 15:30'), $this->newParisTime('11/22/19 16:00')),

            new Slot('One Year of Symfony', $this->newParisTime('11/22/19 16:00'), $this->newParisTime('11/22/19 16:40'), 'Zan Baldwin & Nicolas Grekas'),

            new Slot('Closing session', $this->newParisTime('11/22/19 16:40'), $this->newParisTime('11/22/19 17:00')),
        ];
    }

    private function newParisTime(string $dateTime): \DateTimeImmutable
    {
        return new \DateTimeImmutable($dateTime, new \DateTimeZone('Europe/Paris'));
    }
}
