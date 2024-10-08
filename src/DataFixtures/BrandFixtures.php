<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class BrandFixtures extends Fixture
{

  private $counter = 1;

  public function load(ObjectManager $manager): void
  {
    $brands = [
      'Abarth',
      'Acura',
      'Aixam',
      'Alfa Romeo',
      'Aro',
      'Aston Martin',
      'Audi',
      'Austin',
      'Baic',
      'Bentley',
      'BMW',
      'Bugatti',
      'Buick',
      'Byd',
      'Cadillac',
      'Chatenet',
      'Chevrolet',
      'Chrysler',
      'Citroën',
      'Comarth',
      'Cupra',
      'Dacia',
      'Daewoo',
      'Daihatsu',
      'DFSK',
      'DKW',
      'Dodge',
      'DR',
      'DS Automobiles',
      'Eagle',
      'Excalibur',
      'FAW',
      'Ferrari',
      'Fiat',
      'Ford',
      'Genesis',
      'GMC',
      'Gonow',
      'Grecav',
      'Holden',
      'Honda',
      'Hummer',
      'Hyundai',
      'Ineos',
      'Infiniti',
      'Isuzu',
      'Iveco',
      'Jaguar',
      'Jeep',
      'Kaipan',
      'KG Mobility',
      'Kia',
      'Koenigsegg',
      'KTM X-Bow',
      'Lada',
      'Lamborghini',
      'Lancia',
      'Land Rover',
      'Lexus',
      'Ligier',
      'Lincoln',
      'Lotus',
      'LuAZ',
      'Lynk & Co',
      'Maruti',
      'Maserati',
      'Maxus',
      'Maybach',
      'Mazda',
      'McLaren',
      'Mercedes-Benz',
      'Mercury',
      'Microcar',
      'Mini',
      'Mitsubishi',
      'Morgan',
      'MPM Motors',
      'Nissan',
      'NSU',
      'Nysa',
      'Opel',
      'Peugeot',
      'Plymouth',
      'Polonez',
      'Pontiac',
      'Porsche',
      'Proton',
      'Renault',
      'Rivian',
      'Rols-Royce',
      'Rover',
      'Saab',
      'Samsung',
      'Saturn',
      'Seat',
      'Skoda',
      'Skywell',
      'Smart',
      'SsangYong',
      'Subaru',
      'Suzuki',
      'Syrena',
      'Tarpan',
      'Tata',
      'Tatra',
      'Tavria',
      'Tazzari',
      'Tesla',
      'Toyota',
      'Trabant',
      'Triumph',
      'TVR',
      'Vauxhall',
      'Volkswagen',
      'Volvo',
      'Warszawa',
      'Xev',
      'Yugo',
      'Zaporożec',
      'Zastawa',
    ];

    foreach ($brands as $brandName) {

      $brand = new Brand();
      $brand->setName($brandName);
      $manager->persist($brand);

      $this->addReference('bra-' . $this->counter, $brand);

       // Add debugging statement
       //var_dump("MBrand Reference: bra-" . $this->counter);

      $this->counter++;
    }

    $manager->flush();
  }
}
