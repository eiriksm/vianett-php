<?php

namespace Vianett;

class ClientTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \Vianett\Client
   */
  protected $client;

  public function setUp() {
    $this->client = new Client('username', 'password');
  }

  public function testUsername()
  {
    $this->assertEquals('username', $this->client->getUsername());
    $this->client->setUsername('newusername');
    $this->assertEquals('newusername', $this->client->getUsername());
  }

  public function testPassword()
  {
    $this->assertEquals('password', $this->client->getPassword());
    $this->client->setPassword('newpassword');
    $this->assertEquals('newpassword', $this->client->getPassword());
  }

  public function testRequest()
  {
    $client = $this->getMock('Client');
    $client->expects($this->any())
      ->method('doRequest')
      ->will($this->returnValue('value'));
  }

  public function testResponse()
  {
    $success = "<?xml version=\"1.0\"?>\n<ack refno=\"1234\" errorcode=\"200\">OK</ack>";
    $this->client->parseResponse($success);
  }

  /**
   * @expectedException        \Exception
   * @expectedExceptionMessage Something went wrong. Unable to get valid response.
   */
  public function testResponseNoErrorCode()
  {
    $failure = "<?xml version=\"1.0\"?>\n<ack refno=\"1234\">OK</ack>";
    $this->client->parseResponse($failure);
  }

  /**
   * @expectedException        \Exception
   * @expectedExceptionMessage Error message.
   * @expectedExceptionCode    1234
   */
  public function testResponseErrorCode()
  {
    $failure = "<?xml version=\"1.0\"?>\n<ack refno=\"1234\" errorcode=\"1234\">Error message.</ack>";
    $this->client->parseResponse($failure);
  }
}