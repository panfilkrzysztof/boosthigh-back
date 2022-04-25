<?php

namespace App\DataFixtures;

use App\Entity\Vehicles;
use App\Entity\Devices;
use App\Entity\Components;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // data for random
        $vehiclesType= array("bus", "tram", "train");
        $vehiclesName = ["bus"=>"Autobus", "tram"=>"Tramwaj", "train"=>"Pociąg"];
        $statusType = array("error", "Warning");
        $statusPaymentTerminalDescription = array("Brak połączenia", "Brak zasilania", "Słaby zasięg");
        $statusQrCodeReaderDescription = array("Brak ostrości obrazu", "Slabe oświetlenie otoczenia");
        $statusPrinterDescription = array("Zacięcie papieru", "Brak papieru", "Bład komunikacji");

        // create 15 vehicles
        for ($i = 0; $i < 15; $i++) {
            $vehicles = new Vehicles();
            $vId = $vehicles->getId();
            $type = array_rand($vehiclesType);
            $vehicles->setType($type);
            $vehicles->setName($vehiclesName[$type]." ".random_int(1,100));
            $manager->persist($vehicles);
            
            // create 1 or 2 ticket machine
            $numberOfDevices = random_int(1,2);
            for ($j = 1; $j <= $numberOfDevices; $j++) {
                $devices = new Devices();
                $dId = $devices->getId();
                $devices->setVehicleId($vId);
                $devices->setType("ticket_machine");
                $devices->setName("Biletomat nr ".$j);
                $manager->persist($devices);

                // create payment terminal
                $paymentTerminal = new Components();
                $ptId = $paymentTerminal->getId();
                $paymentTerminal->setDeviceId($dId);
                $paymentTerminal->setType("payment_terminal");
                $paymentTerminal->setName("Terminal płatniczy");
                $manager->persist($paymentTerminal);

                // random status 
                $numberOfPaymentTerminalStatus = random_int(0,2);
                for ($k = 1; $k <= $numberOfPaymentTerminalStatus; $k++) {
                    $status = new Status();
                    $status->setComponentId($ptId);
                    $status->setType(array_rand($statusType));
                    $status->setDescription(array_rand($statusPaymentTerminalDescription));
                    $manager->persist($status);
                }

                // create qr code reader
                $qrCodeReader = new Components();
                $qrId = $qrCodeReader->getId();
                $qrCodeReader->setDeviceId($dId);
                $qrCodeReader->setType("qr_code_reader");
                $qrCodeReader->setName("Czytnik kodów QR");
                $manager->persist($qrCodeReader);
                
                // random status 
                $numberOfQrCodeReaderStatus = random_int(0,2);
                for ($l = 1; $l <= $numberOfQrCodeReaderStatus; $l++) {
                    $status = new Status();
                    $status->setComponentId($qrId);
                    $status->setType(array_rand($statusType));
                    $status->setDescription(array_rand($statusQrCodeReaderDescription));
                    $manager->persist($status);
                }

                // create printer
                $printer = new Components();
                $pId = $printer->getId();
                $printer->setDeviceId($dId);
                $printer->setType("printer");
                $printer->setName("Drukarka termiczna");
                $manager->persist($printer);

                // random status 
                $numberOfPrinterStatus = random_int(0,2);
                for ($m = 1; $m <= $numberOfPrinterStatus; $m++) {
                    $status = new Status();
                    $status->setComponentId($pId);
                    $status->setType(array_rand($statusType));
                    $status->setDescription(array_rand($statusPrinterDescription));
                    $manager->persist($status);
                }

            }
        }

        $manager->flush();
    }
}
