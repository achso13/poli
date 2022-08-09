<?php

use CodeIgniter\Test\CIsatuanTestCase;
use Config\Services;

/**
 * @internal
 */
final class ExampleSessionTest extends CIsatuanTestCase
{
    public function testSessionSimple()
    {
        $session = Services::session();

        $session->set('logged_in', 123);
        $this->assertSame(123, $session->get('logged_in'));
    }
}
