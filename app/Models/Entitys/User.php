<?php

namespace App\Models\Entitys;

use App\Models\Repository\UserRepository;
use App\Traits\Timestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(schema: 'crudweb', name: 'user')]
#[ORM\Entity(UserRepository::class)]
#[UniqueConstraint(name: 'email', columns: ['email'])]
#[HasLifecycleCallbacks]
class User extends AbstractEntity
{

    use Timestamps;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    /**
     * @var string
     */
    #[ORM\Column(name: 'nome', type:'string', nullable: false)]
    private string $name;

    /**
     * @var string
     */
    #[ORM\Column(name: 'email', type:'string', nullable: false)]
    private string $email;

    /**
     * @var string
     */
    #[ORM\Column(name: 'password', type:'string', nullable: false)]
    private string $password;

    /**
     * @var Collection
     */
    #[OneToMany(targetEntity: Annotation::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private Collection $annotations;

    public function __construct()
    {
        $this->annotations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return PersistentCollection
     */
    public function getAnnotations(): Collection
    {
        return $this->annotations;
    }

    /**
     * @param Annotation $annotation
     * @return void
     */
    public function addAnnotation(Annotation $annotation): void
    {
        $this->getAnnotations()->add($annotation);
    }
}