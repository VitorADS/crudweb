<?php

namespace App\Models\Entitys;

use App\Models\Repository\AnnotationRepository;
use App\Traits\Timestamps;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Table(schema: 'crudweb', name: 'annotation')]
#[ORM\Entity(AnnotationRepository::class)]
#[HasLifecycleCallbacks]
class Annotation extends AbstractEntity
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
    #[ORM\Column(name: 'header', type:'string', nullable: false)]
    private string $header;

    /**
     * @var string
     */
    #[ORM\Column(name: 'title', type:'string', nullable: false)]
    private string $title;

    /**
     * @var string
     */
    #[ORM\Column(name: 'text', type:'text', nullable: false)]
    private string $text;

    /**
     * @var User
     */
    #[ManyToOne(targetEntity: User::class, inversedBy: 'annotations')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private User $user;

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
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     * @return void
     */
    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return void
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}