<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Command;

use CertUnlp\NgenBundle\Entity\TelegramMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TelegramCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:telegram:send')
            ->setDescription('Send a message to a Telegram chat.')
            ->addOption('chat_id', '-c', InputOption::VALUE_OPTIONAL, 'ChatId to write to.')
            ->addOption('token', '-t', InputOption::VALUE_OPTIONAL, 'Token to grant acces to chatid.')
            ->addOption('message', '-m', InputOption::VALUE_OPTIONAL, 'The message you want to send.', 'test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[Messages]: Starting.');
        $output->writeln('[Messages]: Sendind Telegram messages...');
        $messages = $this->findMessagesToSend();
        foreach ($messages as $message) {
            $decode_result = json_decode($this->sendMessage($message->getChatID(), $message->getMessage(), $message->getToken(), $output), true);
            if (array_key_exists('error', $decode_result)) {
                $message->setResponse($decode_result['description']);
            } else {
                $message->setResponse($decode_result['result']);
                $message->setPending(FALSE);
            }

            $this->getContainer()->get('doctrine')->getManager()->persist($message);
        }
        $output->writeln('[Messages]: Saving.');
        $this->getContainer()->get('doctrine')->getManager()->flush();
        $output->writeln('[Messages]: Done.');
    }

    /**
     * @return TelegramMessage[]
     */
    private function findMessagesToSend(): array
    {
        return $this->getContainer()->get('doctrine')->getRepository(TelegramMessage::class)->findMessagesToSend();
    }

    /**
     * @param $chatID
     * @param $messaggio
     * @param $token
     * @param OutputInterface $output
     * @return bool|string
     */
    private function sendMessage($chatID, $messaggio, $token, OutputInterface $output)
    {
        $output->writeln('[Messages]: sending message to ' . $chatID);


        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?parse_mode=markdown&chat_id=' . $chatID;
        $url = $url . '&text=' . urlencode($messaggio);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $result;
    }

}
