<?php
class Review
{
    private string $name_plant;
    private string $name;
    private string $message;
    private int $rating;
    private string $reply;
    // Constructor
    public function __construct(string $name_plant, string $name, string $message, int $rating)
    {
        $this->name_plant = $name_plant;
        $this->name = $name;
        $this->message = $message;
        $this->rating = $rating;
    }

    public function __construct2(string $reply)
    {
        $this->reply = $reply;
    }

    public function __construct3()
    {}

    //Get Behavior
    public function getNamePlant(): string
    {
        return $this->name_plant;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getRatting(): int
    {
        return $this->rating;
    }

    public function getReply()
    {
        return $this->reply;
    }
};
