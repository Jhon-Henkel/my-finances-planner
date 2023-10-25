<?php

namespace App\DTO\Mail;

use App\Tools\AppTools;

class MailMessageDTO
{
    private string $addressee;
    private string $addresseeName;
    private string $sender;
    private string $senderName;
    private string $subject;
    private string $templeteFile;
    private array $params;

    public function __construct(
        string $addressee,
        string $addresseeName,
        string $subject,
        string $templeteFile,
        array $params
    ) {
        $this->addressee = $addressee;
        $this->addresseeName = $addresseeName;
        $this->sender = AppTools::getEnvValue('MAIL_FROM_ADDRESS');
        $this->senderName = str_replace('_', ' ', AppTools::getEnvValue('MAIL_FROM_NAME'));
        $this->subject = $subject;
        $this->templeteFile = $templeteFile;
        $this->params = $params;
    }

    public function getAddressee(): string
    {
        return $this->addressee;
    }

    public function getAddresseeName(): string
    {
        return $this->addresseeName;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function getSenderName(): string
    {
        return $this->senderName;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getTempleteFile(): string
    {
        return $this->templeteFile;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}