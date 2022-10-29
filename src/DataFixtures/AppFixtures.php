<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Slot;
use App\Entity\Talk;
use App\Entity\TimeSpan;
use App\Entity\Track;
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
        $slots = [];

        $timeSpan1 = new TimeSpan($this->newParisTime('11/21/19 8:00'), $this->newParisTime('11/21/19 9:00'));
        $slot1 = new Slot($timeSpan1);
        $slot1->addEvent(new Event('Badge pickup and welcome light breakfast ☕🥐', $timeSpan1, $slot1));
        $slots[] = $slot1;

        $timeSpan2 = new TimeSpan($this->newParisTime('11/21/19 9:00'), $this->newParisTime('11/21/19 9:15'));
        $slot2 = new Slot($timeSpan2, $slot1);
        $slot2->addEvent(new Event('🎉 Opening / Welcome session 👋', $timeSpan2, $slot2));
        $slot1->setNext($slot2);
        $slots[] = $slot2;

        $timeSpan3 = new TimeSpan($this->newParisTime('11/21/19 9:15'), $this->newParisTime('11/21/19 9:55'));
        $slot3 = new Slot($timeSpan3, $slot2);
        $slot3->addEvent(new Talk('Keynote', 'Fabien Potencier', '', $timeSpan3, Track::SymfonyRoom, $slot3));
        $slot2->setNext($slot3);
        $slots[] = $slot3;

        $timeSpan4 = new TimeSpan($this->newParisTime('11/21/19 10:05'), $this->newParisTime('11/21/19 10:45'));
        $slot4 = new Slot($timeSpan4, $slot3);
        $slot4->addEvent(new Talk('HTTP/3: It\'s all about the transport!', 'Benoit Jacquemont', '', $timeSpan4, Track::SymfonyRoom, $slot4));
        $slot4->addEvent(new Talk('How to contribute to Symfony and why you should give it a try', 'Valentin Udaltsov', '', $timeSpan4, Track::FrameworkRoom, $slot4));
        $slot4->addEvent(new Talk('A view in the PHP Virtual Machine', 'Julien Pauli', '', $timeSpan4, Track::PlatformRoom, $slot4));
        $slot3->setNext($slot4);
        $slots[] = $slot4;

        $timeSpan5 = new TimeSpan($this->newParisTime('11/21/19 10:45'), $this->newParisTime('11/21/19 11:15'));
        $slot5 = new Slot($timeSpan5, $slot4);
        $slot5->addEvent(new Event('Break ☕ 🥐', $timeSpan5, $slot5));
        $slot4->setNext($slot5);
        $slots[] = $slot5;

        $timeSpan6 = new TimeSpan($this->newParisTime('11/21/19 11:15'), $this->newParisTime('11/21/19 11:55'));
        $slot6 = new Slot($timeSpan6, $slot5);
        $slot6->addEvent(new Talk('How Doctrine caching can skyrocket your application', 'Jachim Coudenys', '', $timeSpan6, Track::SymfonyRoom, $slot6));
        $slot6->addEvent(new Talk('Using the Workflow component for e-commerce', 'Michelle Sanver', '', $timeSpan6, Track::FrameworkRoom, $slot6));
        $slot6->addEvent(new Talk('Crazy Fun Experiments with PHP (Not for Production)', 'Zan Baldwin', '', $timeSpan6, Track::PlatformRoom, $slot6));
        $slot5->setNext($slot6);
        $slots[] = $slot6;

        $timeSpan7 = new TimeSpan($this->newParisTime('11/21/19 12:00'), $this->newParisTime('11/21/19 13:30'));
        $slot7 = new Slot($timeSpan7, $slot6);
        $slot7->addEvent(new Event('Lunch', $timeSpan7, $slot7));
        $slot6->setNext($slot7);
        $slots[] = $slot7;

        $timeSpan8 = new TimeSpan($this->newParisTime('11/21/19 13:30'), $this->newParisTime('11/21/19 14:10'));
        $slot8 = new Slot($timeSpan8, $slot7);
        $slot8->addEvent(new Talk('Hexagonal Architecture with Symfony', 'Matthias Noback', '', $timeSpan8, Track::SymfonyRoom, $slot8));
        $slot8->addEvent(new Talk('Crawling the Web with the New Symfony Components', 'Adiel Cristo', '', $timeSpan8, Track::FrameworkRoom, $slot8));
        $slot8->addEvent(new Talk('Adding Event Sourcing to an existing PHP project (for the right reasons)', 'Alessandro Lai', '', $timeSpan8, Track::PlatformRoom, $slot8));
        $slot7->setNext($slot8);
        $slots[] = $slot8;

        $timeSpan9 = new TimeSpan($this->newParisTime('11/21/19 14:20'), $this->newParisTime('11/21/19 15:00'));
        $slot9 = new Slot($timeSpan9, $slot8);
        $slot9->addEvent(new Talk('HYPErmedia: leveraging HTTP/2 and Symfony for better and faster web APIs', 'Kévin Dunglas', '', $timeSpan9, Track::SymfonyRoom, $slot9));
        $slot9->addEvent(new Talk('PHP, Symfony and Security', 'Diana Ungaro Arnos', '', $timeSpan9, Track::FrameworkRoom, $slot9));
        $slot9->addEvent(new Talk('What happens when you press enter?', 'Tobias Sjösten', '', $timeSpan9, Track::PlatformRoom, $slot9));
        $slot8->setNext($slot9);
        $slots[] = $slot9;

        $timeSpan10 = new TimeSpan($this->newParisTime('11/21/19 15:00'), $this->newParisTime('11/21/19 15:30'));
        $slot10 = new Slot($timeSpan10, $slot9);
        $slot10->addEvent(new Event('Break ☕ 🥐', $timeSpan10, $slot10));
        $slot9->setNext($slot10);
        $slots[] = $slot10;

        $timeSpan11 = new TimeSpan($this->newParisTime('11/21/19 15:30'), $this->newParisTime('11/21/19 16:10'));
        $slot11 = new Slot($timeSpan11, $slot10);
        $slot11->addEvent(new Talk('Configuring Symfony - from localhost to High Availability', 'Nicolas Grekas', '', $timeSpan11, Track::SymfonyRoom, $slot11));
        $slot11->addEvent(new Talk('HTTP Caching with Symfony 101', 'Matthias Pigulla', '', $timeSpan11, Track::FrameworkRoom, $slot11));
        $slot11->addEvent(new Talk('How fitness helps you become a better developer', 'Magnus Nordlander', '', $timeSpan11, Track::PlatformRoom, $slot11));
        $slot10->setNext($slot11);
        $slots[] = $slot11;

        $timeSpan12 = new TimeSpan($this->newParisTime('11/21/19 16:20'), $this->newParisTime('11/21/19 17:00'));
        $slot12 = new Slot($timeSpan12, $slot11);
        $slot12->addEvent(new Event('Meet the Core Team - Roundtable', $timeSpan12, $slot12));
        $slot11->setNext($slot12);
        $slots[] = $slot12;

        $timeSpan13 = new TimeSpan($this->newParisTime('11/21/19 18:00'), $this->newParisTime('11/21/19 21:00'));
        $slot13 = new Slot($timeSpan13, $slot12);
        $slot13->addEvent(new Event('Social event (drinks and snacks)', $timeSpan13, $slot13));
        $slot12->setNext($slot13);
        $slots[] = $slot13;

        return $slots;
    }

    /**
     * @return array<Slot>
     */
    private function loadDayTwo(): array
    {
        $slots = [];

        $timeSpan1 = new TimeSpan($this->newParisTime('11/22/19 8:00'), $this->newParisTime('11/22/19 9:00'));
        $slot1 = new Slot($timeSpan1);
        $slot1->addEvent(new Event('Light breakfast ☕🥐', $timeSpan1, $slot1));
        $slots[] = $slot1;

        $timeSpan2 = new TimeSpan($this->newParisTime('11/22/19 9:00'), $this->newParisTime('11/22/19 9:40'));
        $slot2 = new Slot($timeSpan2, $slot1);
        $slot2->addEvent(new Talk('PHPUnit Best Practices', 'Sebastian Bergmann', '', $timeSpan2, Track::SymfonyRoom, $slot2));
        $slot1->setNext($slot2);
        $slots[] = $slot2;

        $timeSpan3 = new TimeSpan($this->newParisTime('11/22/19 09:50'), $this->newParisTime('11/22/19 10:30'));
        $slot3 = new Slot($timeSpan3, $slot2);
        $slot3->addEvent(new Talk('Using API Platform to build ticketing system', 'Antonio Peric-Mazar', '', $timeSpan3, Track::SymfonyRoom, $slot3));
        $slot3->addEvent(new Talk('Make the Most out of Twig', 'Andrii Yatsenko', '', $timeSpan3, Track::FrameworkRoom, $slot3));
        $slot3->addEvent(new Talk('Mental Health in the Workplace', 'Stefan Koopmanschap', '', $timeSpan3, Track::PlatformRoom, $slot3));
        $slot2->setNext($slot3);
        $slots[] = $slot3;

        $timeSpan4 = new TimeSpan($this->newParisTime('11/22/19 10:30'), $this->newParisTime('11/22/19 11:00'));
        $slot4 = new Slot($timeSpan4, $slot3);
        $slot4->addEvent(new Event('Break ☕ 🥐', $timeSpan4, $slot4));
        $slot3->setNext($slot4);
        $slots[] = $slot4;

        $timeSpan5 = new TimeSpan($this->newParisTime('11/22/19 11:00'), $this->newParisTime('11/22/19 11:40'));
        $slot5 = new Slot($timeSpan5, $slot4);
        $slot5->addEvent(new Talk('Importing bad data - Outputting good data with Symfony', 'Michelle Sanver', '', $timeSpan5, Track::SymfonyRoom, $slot5));
        $slot5->addEvent(new Talk('Symfony Serializer: There and back again', 'Juciellen Cabrera', '', $timeSpan5, Track::FrameworkRoom, $slot5));
        $slot5->addEvent(new Talk('Eeek, my tests are mutating!', 'Lander Vanderstraeten', '', $timeSpan5, Track::PlatformRoom, $slot5));
        $slot4->setNext($slot5);
        $slots[] = $slot5;

        $timeSpan6 = new TimeSpan($this->newParisTime('11/22/19 11:50'), $this->newParisTime('11/22/19 12:30'));
        $slot6 = new Slot($timeSpan6, $slot5);
        $slot6->addEvent(new Talk('Integrating performance management in your development cycle', 'Marc Weistroff', '', $timeSpan6, Track::SymfonyRoom, $slot6));
        $slot6->addEvent(new Talk('Demystifying React JS for Symfony developers', 'Titouan Galopin', '', $timeSpan6, Track::FrameworkRoom, $slot6));
        $slot6->addEvent(new Talk('Head first into Symfony Cache, Redis & Redis Cluster', 'Andre Rømcke', '', $timeSpan6, Track::PlatformRoom, $slot6));
        $slot5->setNext($slot6);
        $slots[] = $slot6;

        $timeSpan7 = new TimeSpan($this->newParisTime('11/22/19 12:30'), $this->newParisTime('11/22/19 14:00'));
        $slot7 = new Slot($timeSpan7, $slot6);
        $slot7->addEvent(new Event('Lunch', $timeSpan7, $slot7));
        $slot6->setNext($slot7);
        $slots[] = $slot7;

        $timeSpan8 = new TimeSpan($this->newParisTime('11/22/19 14:00'), $this->newParisTime('11/22/19 14:40'));
        $slot8 = new Slot($timeSpan8, $slot7);
        $slot8->addEvent(new Talk('Prime Time with Messenger: Queues, Workers & more Fun!', 'Ryan Weaver', '', $timeSpan8, Track::SymfonyRoom, $slot8));
        $slot8->addEvent(new Talk('SymfonyCloud: the infrastructure of the Symfony ecosystem', 'Tugdual Saunier', '', $timeSpan8, Track::FrameworkRoom, $slot8));
        $slot8->addEvent(new Talk('Together towards an AI, NEAT plus ultra', 'Grégoire Hébert', '', $timeSpan8, Track::PlatformRoom, $slot8));
        $slot7->setNext($slot8);
        $slots[] = $slot8;

        $timeSpan9 = new TimeSpan($this->newParisTime('11/22/19 14:50'), $this->newParisTime('11/22/19 15:30'));
        $slot9 = new Slot($timeSpan9, $slot8);
        $slot9->addEvent(new Talk('Building really fast applications', 'Tobias Nyholm', '', $timeSpan9, Track::SymfonyRoom, $slot9));
        $slot9->addEvent(new Talk('Everything you wanted to know about Sylius, but didn’t find time to ask', 'Łukasz Chruściel', '', $timeSpan9, Track::FrameworkRoom, $slot9));
        $slot9->addEvent(new Talk('DevCorp: Choose Your Own Adventure', 'Pauline Vos', '', $timeSpan9, Track::PlatformRoom, $slot9));
        $slot8->setNext($slot9);
        $slots[] = $slot9;

        $timeSpan10 = new TimeSpan($this->newParisTime('11/22/19 15:30'), $this->newParisTime('11/22/19 16:00'));
        $slot10 = new Slot($timeSpan10, $slot9);
        $slot10->addEvent(new Event('Break ☕ 🥐', $timeSpan10, $slot10));
        $slot9->setNext($slot10);
        $slots[] = $slot10;

        $timeSpan11 = new TimeSpan($this->newParisTime('11/22/19 16:00'), $this->newParisTime('11/22/19 16:40'));
        $slot11 = new Slot($timeSpan11, $slot10);
        $slot11->addEvent(new Talk('One Year of Symfony', 'Zan Baldwin & Nicolas Grekas', '', $timeSpan11, Track::SymfonyRoom, $slot11));
        $slot10->setNext($slot11);
        $slots[] = $slot11;

        $timeSpan12 = new TimeSpan($this->newParisTime('11/22/19 16:40'), $this->newParisTime('11/22/19 17:00'));
        $slot12 = new Slot($timeSpan12, $slot11);
        $slot12->addEvent(new Event('Closing session', $timeSpan12, $slot12));
        $slot11->setNext($slot12);
        $slots[] = $slot12;

        return $slots;
    }

    private function newParisTime(string $dateTime): \DateTimeImmutable
    {
        return new \DateTimeImmutable($dateTime, new \DateTimeZone('Europe/Paris'));
    }
}
