<?php

/**
 * Lenevor Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file license.md.
 * It is also available through the world-wide-web at this URL:
 * https://lenevor.com/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@Lenevor.com so we can send you a copy immediately.
 *
 * @package     Lenevor
 * @subpackage  Base
 * @link        https://lenevor.com
 * @copyright   Copyright (c) 2019 - 2025 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://lenevor.com/license or see /license.md
 */

namespace Syscodes\Components\Mail\Headers;

use LogicException;
use DateTimeInterface;
use Syscodes\Components\Contracts\Mail\Header;
use Syscodes\Components\Mail\Mailables\Address;

/**
 * Headers class is a container for email headers.
 */
class Headers implements Header
{
    /**
     * Gets the headers class map.
     */
    protected const HEADER_CLASS_MAP = [
        'date' => DateHeader::class,
        'from' => MailboxListHeader::class,
        'sender' => MailboxHeader::class,
        'reply-to' => MailboxListHeader::class,
        'to' => MailboxListHeader::class,
        'cc' => MailboxListHeader::class,
        'bcc' => MailboxListHeader::class,
        'message-id' => IdentificationMessageHeader::class,
        'in-reply-to' => [FileHeader::class, IdentificationMessageHeader::class],
        'references' => [FileHeader::class, IdentificationMessageHeader::class],
        'return-path' => PathHeader::class,
    ];

    /**
     * Gets the unique headers.
     */
    protected const UNIQUE_HEADERS = [
        'date',
        'from',
        'sender',
        'reply-to',
        'to',
        'cc',
        'bcc',
        'message-id',
        'in-reply-to',
        'references',
        'subject',
    ];

    /**
     * Get the address of the recipients.
     * 
     * @var array $address
     */
    protected array $address;
    
    /**
     * An array of HTTP headers.
     * 
     * @var array $headers
     */
    protected array $headers = [];
    
    /**
     * Get the line length of a message.
     * 
     * @var int $lineLenght
     */
    protected int $lineLength = 76;

    /**
     * Get the name.
     * 
     * @var string $name
     */
    protected string $name;

    /**
     * Constructor. Create a new Headers class instance.
     * 
     * @param array  $address
     * @param  array  $headers
     * 
     * @return void
     */
    public function __construct(array $address = [], array $headers = [])
    {
        foreach ($headers as $header) {
            $this->add($header);
        }
        
        $this->setAddress($address);
    }
    
    /**
     * Adds multiple header.
     * 
     * @param  mixed  $headers  The header name
     * 
     * @return static
     */
    public function add(mixed $headers): static
    {
        static::checkHeaderClass($headers);
        
        $this->setMaxLineLength($this->lineLength);

        $name = strtolower($this->getName());

        if (in_array($name, self::UNIQUE_HEADERS, true) && isset($this->headers[$name]) && count($this->headers[$name]) > 0) {
            throw new LogicException(sprintf(
                'Impossible to set header "%s" as it\'s already defined and must be unique', implode('', $this->getNames())
            ));
        }

        $this->headers[$name][] = $headers;

        return $this;
    }

    /**
     * Gets the name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name.
     * 
     * @param  string  $name
     * 
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Sets a list of addresses to be shown in this Header.
     * 
     * @param  Address[]  $address
     */
    public function setAddress(array $address): void
    {
        $this->address = [];
        $this->addAddresses($address);
    }
    
    /**
     * Sets a list of addresses to be shown in this Header.
     * 
     * @param  Address[]  $addresses
     *
     * @return void 
     */
    public function addAddresses(array $addresses): void
    {
        foreach ($addresses as $address) {
            $this->addAddress($address);
        }
    }
    
    /**
     * Adds the address to send of mailbox.
     * 
     * @param  Address  $address
     * 
     * @return void
     */
    public function addAddress(Address $address): void
    {
        $this->address[] = $address;
    }
    
    /**
     * Gets the list of address.
     * 
     * @return Address[]
     */
    public function getAddress(): array
    {
        return $this->address;
    }
    
    /**
     * Adds the mailbox list header.
     * 
     * @param  string  $name
     * @param  array<Address|string>  $addresses
     * 
     * @return static
     */
    public function addMailboxListHeader(string $name, array $addresses): static
    {
        return $this->add(new MailboxListHeader($name, Address::createArray($addresses)));
    }
    
    /**
     * Adds the mailbox header.
     * 
     * @param  string  $name
     * @param  Address|string  $address
     * 
     * @return static
     */
    public function addMailboxHeader(string $name, Address|string $address): static
    {
        return $this->add(new MailboxHeader($name, Address::create($address)));
    }
    
    /**
     * Adds the identification message header.
     * 
     * @param  string  $name
     * @param  string|string[]  $ids
     * 
     * @return static
     */
    public function addIdnHeader(string $name, string|array $ids): static
    {
        return $this->add(new IdentificationMessageHeader($name, $ids));
    }
    
    /**
     * Adds the identification message header.
     * 
     * @param  string  $name
     * @param  string|string[]  $path
     * 
     * @return static
     */
    public function addPathHeader(string $name, Address|string $path): static
    {
        return $this->add(new PathHeader($name, $path instanceof Address ? $path : new Address($path)));
    }
    
    /**
     * Adds the date header.
     * 
     * @param  string  $name
     * @param  \DateTimeInterface  $dataTime
     * 
     * @return static
     */
    public function addDateHeader(string $name, DateTimeInterface $dateTime): static
    {
        return $this->add(new DateHeader($name, $dateTime));
    }
    
    /**
     * Adds the text header.
     * 
     * @param  string  $name
     * @param  string  $value
     * 
     * @return static
     */
    public function addTextHeader(string $name, string $value): static
    {
        return $this->add(new FileHeader($name, $value));
    }
    
    /**
     * Adds the header from an array.
     * 
     * @param  string  $name
     * @param  mixed  $argument
     * @param  array  $array
     * 
     * @return static
     */
    public function addHeader(string $name, mixed $argument, array $array = []): static
    {
        $headerClass = self::HEADER_CLASS_MAP[strtolower($name)] ?? FileHeader::class;
        
        if (is_array($headerClass)) {
            $headerClass = $headerClass[0];
        }
        
        $parts  = explode('\\', $headerClass);
        $method = 'add'.ucfirst(array_pop($parts));
        
        if ('addFileHeader' === $method) {
            $method = 'addTextHeader';
        } elseif ('addIdentificationMessageHeader' === $method) {
            $method = 'addIdnHeader';
        } elseif ('addMailboxListHeader' === $method && ! is_array($argument)) {
            $argument = [$argument];
        }
        
        return $this->$method($name, $argument, $array);
    }
    
    /**
     * If exist the name of header.
     * 
     * @param  string  $name
     * 
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    /**
     * Gets a header value by name.
     * 
     * @param  string  $name
     * 
     * @return mixed
     */
    public function get(string $name): mixed
    {
        $name = strtolower($name);
        
        if ( ! isset($this->headers[$name])) {
            return null;
        }
        
        $values = array_values($this->headers[$name]);
        
        return array_shift($values);
    }

    /**
     * Returns all the headers.
     * 
     * @param  string|null  $name
     * 
     * @return \iterable
     */
    public function all(?string $name = null): iterable
    {
        if (null === $name) {
            foreach ($this->headers as $name => $collection) {
                foreach ($collection as $header) {
                    yield $name => $header;
                }
            }
        } elseif (isset($this->headers[strtolower($name)])) {
            foreach ($this->headers[strtolower($name)] as $header) {
                yield $header;
            }
        }
    }
    
    /**
     * Removes a header.
     * 
     * @param  string  $name  The header name
     * 
     * @return void
     */
    public function remove(string $name): void
    {
        unset($this->headers[strtolower($name)]);
    }
    
    /**
     * Gets the name.
     * 
     * @return array
     */
    public function getNames(): array
    {
        return array_keys($this->headers);
    }

    /**
     * Gets the headers.
     * 
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
    
    /**
     * Sets the max line length.
     * 
     * @param  int  $lineLength
     * 
     * @return void
     */
    public function setMaxLineLength(int $lineLength): void
    {
        $this->lineLength = $lineLength;
    }
    
    /**
     * Gets the max line length.
     * 
     * @return int
     */
    public function getMaxLineLength(): int
    {
        return $this->lineLength;
    }
    
    /**
     * Get the header body.
     * 
     * @param  string  $name
     * 
     * @return mixed
     */
    public function getHeaderBody(string $name): mixed
    {
        return $this->has($name) ? $this->get($name)->getBody() : null;
    }
    
    /**
     * Set the header body. 
     * 
     * @param  string  $type
     * @param  string  $name
     * @param  mixed  $body
     * 
     * @return void
     */
    public function setHeaderBody(string $type, string $name, mixed $body): void
    {
        if ($this->has($name)) {
            $this->get($name)->setBody($body);
        } else {
            $this->{'add'.$type.'Header'}($name, $body);
        }
    }
    
    /**
     * Checks the header class.
     * 
     * @param  mixed  $header
     * 
     * @return void
     */
    public static function checkHeaderClass(mixed $header): void
    {
        $name = strtolower($header->getName());
        
        $headerClasses = self::HEADER_CLASS_MAP[$name] ?? [];
        
        if ( ! is_array($headerClasses)) {
            $headerClasses = [$headerClasses];
        }
        
        if ( ! $headerClasses) {
            return;
        }
        
        foreach ($headerClasses as $class) {
            if ($header instanceof $class) {
                return;
            }
        }
    }
    
    /**
     * Gets this Header rendered as a compliant string.
     * 
     * @return string
     */
    public function toString(): string
    {
        $string = '';
        
        foreach ($this->toArray() as $str) {
            $string .= $str."\r\n";
        }
        
        return $string;
    }

    /**
     * Get the instance as an array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        $arr = [];
        
        foreach ($this->all() as $header) {
            $arr[] = $header;
        }
        
        return $arr;
    }
    
    /**
     * Magic method.
     * 
     * Force a clone of the underlying headers when cloning.
     * 
     * @return void
     */
    public function __clone()
    {
        foreach ($this->headers as $name => $collection) {
            foreach ($collection as $i => $header) {
                $this->headers[$name][$i] = clone $header;
            }
        }
    }
}