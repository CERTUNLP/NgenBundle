<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Entity\Network;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @author dam
 * @ORM\Entity()
 */
class NetworkRdap extends Network
{
    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $start_address;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $end_address;

    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $country;

    /**
     * Get endAddress
     *
     * @return string
     */
    public function getEndAddress(): string
    {
        return $this->end_address;
    }


    /**
     * @param string $end_address
     * @return NetworkRdap
     */
    public function setEndAddress(string $end_address): NetworkRdap
    {
        $this->end_address = $end_address;
        $this->renewIp();

        return $this;
    }

    /**
     * Set ip
     *
     * @return NetworkRdap
     */
    public function renewIp(): NetworkRdap
    {
        if ($this->getStartAddress() && $this->getEndAddress()) {
            $this->setIp($this->iprange2cidr($this->getStartAddress(), $this->getEndAddress()));
        }
        return $this;
    }

    /**
     * Get startAddress
     *
     * @return string
     */
    public function getStartAddress(): string
    {
        return $this->start_address;
    }

    /**
     * Set startAddress
     *
     * @param string $startAddress
     *
     * @return NetworkRdap
     */
    public function setStartAddress(string $startAddress): NetworkRdap
    {
        $this->start_address = $startAddress;

        return $this;
    }

    private function iprange2cidr(string $ipStart, string $ipEnd): string
    {
        $start = ip2long($ipStart);
        $end = ip2long($ipEnd);
        $result = array();
        while ($end >= $start) {
            $maxSize = 32;
            while ($maxSize > 0) {
                $mask = hexdec($this->iMask($maxSize - 1));
                $maskBase = $start & $mask;
                if ($maskBase !== $start) {
                    break;
                }
                $maxSize--;
            }
            $x = log($end - $start + 1) / log(2);
            $maxDiff = floor(32 - floor($x));
            if ($maxSize < $maxDiff) {
                $maxSize = $maxDiff;
            }
            $ip = long2ip($start);
            $result[] = "$ip/$maxSize";
            $start += 2 ** (32 - $maxSize);
        }
        return $result[0];
    }

    private function iMask(int $s): string
    {
        return base_convert((2 ** 32) - (2 ** (32 - $s)), 10, 16);
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return NetworkRdap
     */
    public function setCountry(string $country): NetworkRdap
    {
        $this->country = $country;

        return $this;
    }

}
