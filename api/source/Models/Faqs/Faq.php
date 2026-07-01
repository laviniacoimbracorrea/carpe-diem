<?php

namespace Source\Models\Faqs;

use Source\Core\Model;
use Source\Core\Connect;

class Faq extends Model
{
    private ?int $id;
    private ?int $faqsCategoryId;
    private ?string $question;
    private ?string $answer;
    private ?int $active; 

    public function __construct(?int $id = null, ?int $faqsCategoryId = null, ?string $question = null, ?string $answer = null, ?int $active = null)
    {
        $this->id = $id;
        $this->faqsCategoryId = $faqsCategoryId;
        $this->question = $question;
        $this->answer = $answer;
        $this->active = $active;

        $this->table = 'faqs';
        $this->primaryKey = 'id';
        $this->fillable = ['faqsCategoryId', 'question', 'answer', 'active'];
    }

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function setId(?int $id = null): void 
    {
        $this->id = $id;
    }

    public function getFaqsCategoryId(): ?int 
    {
        return $this->faqsCategoryId;
    }

    public function setFaqsCategoryId(?int $faqsCategoryId = null)
    {
        $this->faqsCategoryId = $faqsCategoryId;
    }

    public function getQuestion(): ?string 
    {
        return $this->question;
    }

    public function setQuestion(?string $question = null): void 
    {
        $this->question = $question;
    }

    public function getAnswer(): ? string 
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer = null): void 
    {
        $this->answer = $answer;
    }

    public function getActive(): ?int 
    {
        return $this->active;
    }

    public function setActive(?int $active = null): void 
    {
        $this->active = $active;
    }

}