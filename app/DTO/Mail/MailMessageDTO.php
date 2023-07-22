<?php

namespace App\DTO\Mail;

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
        $this->sender = env('MAIL_FROM_ADDRESS');
        $this->senderName = str_replace('_', ' ', env('MAIL_FROM_NAME'));
        $this->subject = $subject;
        $this->templeteFile = $templeteFile;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getAddressee(): string
    {
        return $this->addressee;
    }

    /**
     * @return string
     */
    public function getAddresseeName(): string
    {
        return $this->addresseeName;
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getTempleteFile(): string
    {
        return $this->templeteFile;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}