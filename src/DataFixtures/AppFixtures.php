<?php

namespace App\DataFixtures;

use App\Entity\Slot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

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

    private function loadDayOne(): array
    {
        return [
            new Slot('Badge pickup and welcome light breakfast ☕🥐', new \DateTimeImmutable('11/21/19 8:00'), new \DateTimeImmutable('11/21/19 9:00')),
            new Slot('🎉 Opening / Welcome session 👋', new \DateTimeImmutable('11/21/19 9:00'), new \DateTimeImmutable('11/21/19 9:15')),
            new Slot('Keynote', new \DateTimeImmutable('11/21/19 9:15'), new \DateTimeImmutable('11/21/19 9:55'), 'Fabien Potencier'),

            new Slot('HTTP/3: It\'s all about the transport!', new \DateTimeImmutable('11/21/19 10:05'), new \DateTimeImmutable('11/21/19 10:45'), 'Benoit Jacquemont', 'Advanced'),
            new Slot('How to contribute to Symfony and why you should give it a try', new \DateTimeImmutable('11/21/19 10:05'), new \DateTimeImmutable('11/21/19 10:45'), 'Valentin Udaltsov', 'Beginner'),
            new Slot('A view in the PHP Virtual Machine', new \DateTimeImmutable('11/21/19 10:05'), new \DateTimeImmutable('11/21/19 10:45'), 'Julien Pauli', 'PHP'),

            new Slot('Break ☕ 🥐', new \DateTimeImmutable('11/21/19 10:45'), new \DateTimeImmutable('11/21/19 11:15')),

            new Slot('How Doctrine caching can skyrocket your application', new \DateTimeImmutable('11/21/19 11:15'), new \DateTimeImmutable('11/21/19 11:55'), 'Jachim Coudenys', 'Advanced'),
            new Slot('Evolving with Symfony in a long-term project', new \DateTimeImmutable('11/21/19 11:15'), new \DateTimeImmutable('11/21/19 11:55'), 'Tobias Schultze', 'Beginner'),
            new Slot('Crazy Fun Experiments with PHP (Not for Production)', new \DateTimeImmutable('11/21/19 11:15'), new \DateTimeImmutable('11/21/19 11:55'), 'Zan Baldwin', 'PHP'),

            new Slot('Lunch', new \DateTimeImmutable('11/21/19 12:00'), new \DateTimeImmutable('11/21/19 13:30')),

            new Slot('Hexagonal Architecture with Symfony', new \DateTimeImmutable('11/21/19 13:30'), new \DateTimeImmutable('11/21/19 14:10'), 'Matthias Noback', 'Advanced'),
            new Slot('Crawling the Web with the New Symfony Components', new \DateTimeImmutable('11/21/19 13:30'), new \DateTimeImmutable('11/21/19 14:10'), 'Adiel Cristo', 'Beginner'),
            new Slot('Adding Event Sourcing to an existing PHP project (for the right reasons)', new \DateTimeImmutable('11/21/19 13:30'), new \DateTimeImmutable('11/21/19 14:10'), 'Alessandro Lai', 'PHP'),

            new Slot('HYPErmedia: leveraging HTTP/2 and Symfony for better and faster web APIs', new \DateTimeImmutable('11/21/19 14:20'), new \DateTimeImmutable('11/21/19 15:00'), 'Kévin Dunglas', 'Advanced'),
            new Slot('PHP, Symfony and Security', new \DateTimeImmutable('11/21/19 14:20'), new \DateTimeImmutable('11/21/19 15:00'), 'Diana Ungaro Arnos', 'Beginner'),
            new Slot('What happens when you press enter?', new \DateTimeImmutable('11/21/19 14:20'), new \DateTimeImmutable('11/21/19 15:00'), 'Tobias Sjösten', 'PHP'),

            new Slot('Break ☕ 🥐', new \DateTimeImmutable('11/21/19 15:00'), new \DateTimeImmutable('11/21/19 15:30')),

            new Slot('Configuring Symfony - from localhost to High Availability', new \DateTimeImmutable('11/21/19 15:30'), new \DateTimeImmutable('11/21/19 16:10'), 'Nicolas Grekas', 'Advanced'),
            new Slot('HTTP Caching with Symfony 101', new \DateTimeImmutable('11/21/19 15:30'), new \DateTimeImmutable('11/21/19 16:10'), 'Matthias Pigulla', 'Beginner'),
            new Slot('How fitness helps you become a better developer', new \DateTimeImmutable('11/21/19 15:30'), new \DateTimeImmutable('11/21/19 16:10'), 'Magnus Nordlander', 'PHP'),

            new Slot('Meet the Core Team - Roundtable', new \DateTimeImmutable('11/21/19 16:20'), new \DateTimeImmutable('11/21/19 17:00')),

            new Slot('Social event (drinks and snacks)', new \DateTimeImmutable('11/21/19 18:00'), new \DateTimeImmutable('11/21/19 21:00')),
        ];
    }

    private function loadDayTwo(): array
    {
        return [
            new Slot('Light breakfast ☕🥐', new \DateTimeImmutable('11/22/19 8:00'), new \DateTimeImmutable('11/22/19 9:00')),
            new Slot('PHPUnit Best Practices', new \DateTimeImmutable('11/22/19 9:00'), new \DateTimeImmutable('11/22/19 9:40'), 'Sebastian Bergmann'),

            new Slot('Using API Platform to build ticketing system', new \DateTimeImmutable('11/22/19 09:50'), new \DateTimeImmutable('11/22/19 10:30'), 'Antonio Peric-Mazar', 'Advanced'),
            new Slot('Make the Most out of Twig', new \DateTimeImmutable('11/22/19 09:50'), new \DateTimeImmutable('11/22/19 10:30'), 'Andrii Yatsenko', 'Beginner'),
            new Slot('Mental Health in the Workplace', new \DateTimeImmutable('11/22/19 09:50'), new \DateTimeImmutable('11/22/19 10:30'), 'Stefan Koopmanschap', 'PHP'),

            new Slot('Break ☕ 🥐', new \DateTimeImmutable('11/22/19 10:30'), new \DateTimeImmutable('11/22/19 11:00')),

            new Slot('Importing bad data - Outputting good data with Symfony', new \DateTimeImmutable('11/22/19 11:00'), new \DateTimeImmutable('11/22/19 11:40'), 'Michelle Sanver', 'Advanced'),
            new Slot('Symfony Serializer: There and back again', new \DateTimeImmutable('11/22/19 11:00'), new \DateTimeImmutable('11/22/19 11:40'), 'Juciellen Cabrera', 'Beginner'),
            new Slot('Eeek, my tests are mutating!', new \DateTimeImmutable('11/22/19 11:00'), new \DateTimeImmutable('11/22/19 11:40'), 'Lander Vanderstraeten', 'PHP'),

            new Slot('Integrating performance management in your development cycle', new \DateTimeImmutable('11/22/19 11:50'), new \DateTimeImmutable('11/22/19 12:30'), 'Marc Weistroff', 'Advanced'),
            new Slot('Demystifying React JS for Symfony developers', new \DateTimeImmutable('11/22/19 11:50'), new \DateTimeImmutable('11/22/19 12:30'), 'Titouan Galopin', 'Beginner'),
            new Slot('Head first into Symfony Cache, Redis & Redis Cluster', new \DateTimeImmutable('11/22/19 11:50'), new \DateTimeImmutable('11/22/19 12:30'), 'Andre Rømcke', 'PHP'),

            new Slot('Lunch', new \DateTimeImmutable('11/22/19 12:30'), new \DateTimeImmutable('11/22/19 14:00')),

            new Slot('Prime Time with Messenger: Queues, Workers & more Fun!', new \DateTimeImmutable('11/22/19 14:00'), new \DateTimeImmutable('11/22/19 14:40'), 'Ryan Weaver', 'Advanced'),
            new Slot('SymfonyCloud: the infrastructure of the Symfony ecosystem', new \DateTimeImmutable('11/22/19 14:00'), new \DateTimeImmutable('11/22/19 14:40'), 'Tugdual Saunier', 'Beginner'),
            new Slot('Together towards an AI, NEAT plus ultra', new \DateTimeImmutable('11/22/19 14:00'), new \DateTimeImmutable('11/22/19 14:40'), 'Grégoire Hébert', 'PHP'),

            new Slot('Building really fast applications', new \DateTimeImmutable('11/22/19 14:50'), new \DateTimeImmutable('11/22/19 15:30'), 'Tobias Nyholm', 'Advanced'),
            new Slot('Everything you wanted to know about Sylius, but didn’t find time to ask', new \DateTimeImmutable('11/22/19 14:50'), new \DateTimeImmutable('11/22/19 15:30'), 'Łukasz Chruściel', 'Beginner'),
            new Slot('DevCorp: Choose Your Own Adventure', new \DateTimeImmutable('11/22/19 14:50'), new \DateTimeImmutable('11/22/19 15:30'), 'Pauline Vos', 'PHP'),

            new Slot('Break ☕ 🥐', new \DateTimeImmutable('11/22/19 15:30'), new \DateTimeImmutable('11/22/19 16:00')),

            new Slot('One Year of Symfony', new \DateTimeImmutable('11/22/19 16:00'), new \DateTimeImmutable('11/22/19 16:40'), 'Zan Baldwin & Nicolas Grekas'),

            new Slot('Closing session', new \DateTimeImmutable('11/22/19 16:40'), new \DateTimeImmutable('11/22/19 17:00')),
        ];
    }
}
