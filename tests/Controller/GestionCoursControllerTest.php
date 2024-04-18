<?php

namespace App\Test\Controller;

use App\Entity\GestionCours;
use App\Repository\GestionCoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GestionCoursControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private GestionCoursRepository $repository;
    private string $path = '/cours/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(GestionCours::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('GestionCour index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'gestion_cour[numero_biblio]' => 'Testing',
            'gestion_cour[titre]' => 'Testing',
            'gestion_cour[pdf]' => 'Testing',
            'gestion_cour[video]' => 'Testing',
            'gestion_cour[nombre_pages]' => 'Testing',
        ]);

        self::assertResponseRedirects('/cours/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new GestionCours();
        $fixture->setNumero_biblio('My Title');
        $fixture->setTitre('My Title');
        $fixture->setPdf('My Title');
        $fixture->setVideo('My Title');
        $fixture->setNombre_pages('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('GestionCour');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new GestionCours();
        $fixture->setNumero_biblio('My Title');
        $fixture->setTitre('My Title');
        $fixture->setPdf('My Title');
        $fixture->setVideo('My Title');
        $fixture->setNombre_pages('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'gestion_cour[numero_biblio]' => 'Something New',
            'gestion_cour[titre]' => 'Something New',
            'gestion_cour[pdf]' => 'Something New',
            'gestion_cour[video]' => 'Something New',
            'gestion_cour[nombre_pages]' => 'Something New',
        ]);

        self::assertResponseRedirects('/cours/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNumero_biblio());
        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getPdf());
        self::assertSame('Something New', $fixture[0]->getVideo());
        self::assertSame('Something New', $fixture[0]->getNombre_pages());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new GestionCours();
        $fixture->setNumero_biblio('My Title');
        $fixture->setTitre('My Title');
        $fixture->setPdf('My Title');
        $fixture->setVideo('My Title');
        $fixture->setNombre_pages('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/cours/');
    }
}
