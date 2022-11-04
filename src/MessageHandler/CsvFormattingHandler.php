<?php

namespace App\MessageHandler;

use League\Csv\Reader;
use League\Csv\Writer;
use App\Message\CsvFormatting;
use App\Message\MailNotification;
use App\Interface\FormatterInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsMessageHandler]
class CsvFormattingHandler
{
    public function __construct(
        private ContainerInterface $container, 
        private MessageBusInterface $bus)
    {}

    public function __invoke(CsvFormatting $message)
    {
        if(file_exists($message->getPath())) {
            $csvpath = $message->getPath();
            $formatter = $this->container->get($message->getFormatter());

            $error='';
            try {
                $newRecords = $this->formatFile($csvpath, $formatter);
                $csvpath = $this->writeNewFile($newRecords, $csvpath);
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
            

            if($message->getEmail()) {
                // will cause the MailNotificationHandler to be called
                $this->bus->dispatch(new MailNotification($csvpath, $message->getEmail(), time(), $error));
            }
        }
    }

    /**
     * Format CSV file records
     *
     * @param string $filepath
     * @param FormatterInterface $formatter
     * @return array formatted records
     */
    private function formatFile(string $filepath, FormatterInterface $formatter): array
    {
        //load the CSV document from a file path
        $csv = Reader::createFromPath($filepath, 'r');
        $csv->setHeaderOffset(null);
        
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object
        
        $newRecords = [];
        foreach($records as $record) {
            $newRecords[] = $formatter->format($record);
        }

        return $newRecords;
    }

    /**
     * Write the new CSV file
     *
     * @param array $records
     * @param string $filepath
     * @return string
     */
    private function writeNewFile(array $records, string $filepath): string
    {
        //load the CSV document from a file path
        $csv = Writer::createFromString();
        
        $records = $csv->insertAll($records); //returns all the CSV records as an Iterator object
        
        file_put_contents($filepath, $csv->toString());

        return $filepath;
    }
}