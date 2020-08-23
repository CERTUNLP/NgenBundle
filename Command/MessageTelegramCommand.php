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

use CertUnlp\NgenBundle\Repository\Communication\Message\MessageTelegramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MessageTelegramCommand extends ContainerAwareCommand
{
    /**
     * @var MessageTelegramRepository
     */
    private $telegram_repository;
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    public function __construct(MessageTelegramRepository $telegram_repository, EntityManagerInterface $doctrine)
    {
        parent::__construct(null);
        $this->telegram_repository = $telegram_repository;
        $this->doctrine = $doctrine;
    }

    public function configure()
    {
        $this
            ->setName('cert_unlp:message:telegram:send')
            ->setDescription('Send a message to a Telegram chat.')
            ->addOption('chat_id', '-c', InputOption::VALUE_OPTIONAL, 'ChatId to write to.')
            ->addOption('token', '-t', InputOption::VALUE_OPTIONAL, 'Token to grant acces to chatid.')
            ->addOption('message', '-m', InputOption::VALUE_OPTIONAL, 'The message you want to send.', 'test');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[message][telegram]: Starting.');
        $limit = 50;
        $offset = 0;
        $messages = $this->getTelegramRepository()->findByPending(true);
        while ($messages) {
            $output->write('[message][telegram]:<info> Found ' . count($messages) . ' messages to send.</info>');
            $output->writeln('<info>Total analyzed ' . $offset . '</info>');
            foreach ($messages as $message) {
                $output->write('<comment>[message][telegram]: sending message(' . $message->getId() . ') to client(' . $message->getChatID() . ')</comment>');
                $decode_result = json_decode($this->sendMessage($message->getChatID(), $message->getMessage(), $message->getToken()), true);
                if (array_key_exists('error_code', $decode_result)) {
                    $message->addResponse($decode_result);
                    $output->writeln('<error>...error: ' . $decode_result['description'] . '</error>');
                } else {
                    $message->addResponse($decode_result);
                    $message->setPending(false);
                    $output->writeln('<info>...sended. </info>');
                }
                $this->getDoctrine()->persist($message);
            }
            $offset += $limit;
            $output->writeln('<info>[message][telegram]: Persisting sended messages.</info>');
            $this->getDoctrine()->flush();
            $output->writeln('<info>[message][telegram]: Done.</info>');
            $messages = $this->getTelegramRepository()->findByPending(true);
        }
        $output->writeln('[message][telegram]: Finished.');
    }

    /**
     * @return MessageTelegramRepository
     */
    public function getTelegramRepository(): MessageTelegramRepository
    {
        return $this->telegram_repository;
    }

    /**
     * @param string $chatID
     * @param string $message
     * @param string $token
     * @return bool|string
     */
    private function sendMessage(string $chatID, string $message, string $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?parse_mode=markdown&chat_id=' . $chatID;
        $url .= '&text=' . urlencode($message);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
//        $err = curl_error($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getDoctrine(): EntityManagerInterface
    {
        return $this->doctrine;
    }

}
