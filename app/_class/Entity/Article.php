<?php

namespace Entity;

use Yeap\Entity;

class Article extends Entity
{
    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;

    /** @Column(type="string") */
    private $headline;

    /** @ManyToOne(targetEntity="User") */
    private $author;

    /** @OneToMany(targetEntity="Comment", mappedBy="article") */
    private $comments;

    public function __construct() 
    {
        $this->comments = new ArrayCollection();
    }

    public function getAuthor() 
    {
    	 return $this->author; 
	}
	
    public function getComments() 
    {
    	 return $this->comments; 
	}
}