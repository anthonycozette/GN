<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EvenementsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $date =new DateTimeImmutable();

        $evenement = new Evenement();
        $evenement->setNom('dongeon dragon');
        $evenement->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent cursus, nisl vel luctus ultricies, lorem odio fermentum neque, a dignissim quam dui in dolor. Morbi vel nunc dapibus, facilisis nunc eget, accumsan sem. Nullam lobortis lacus nec orci aliquam viverra. Quisque ac lorem facilisis, fermentum mauris vitae, consequat tellus. Ut ultricies, neque nec congue accumsan, enim metus pharetra tortor, sit amet porttitor purus nisi a quam. Nulla eget tincidunt enim. Integer velit ipsum, commodo in odio vel, vulputate fringilla magna. Phasellus ut ultricies felis, ut molestie metus. Vestibulum eget justo ligula. Aliquam pretium eros id congue interdum. Vivamus sed nibh non leo gravida mattis. Pellentesque efficitur quam et massa sollicitudin, placerat viverra leo cursus. Duis egestas ullamcorper lacus, ac viverra augue tempus sed.');
        $evenement->setPrix(60);
        $evenement->setImageName("th (1).jpg");
        $evenement->setUpdatedAt($date);
        $manager->persist($evenement);

        $manager->flush();
    }
}
