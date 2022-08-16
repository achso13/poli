<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Role implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if ($arguments === 'ADMIN') {
            if (session()->get('role') !== 'ADMIN') {
                return redirect()->to('/');
            }
        }

        if ($arguments === 'PASIEN') {
            if (session()->get('role') !== 'PASIEN') {
                return redirect()->to('/');
            }
        }

        if ($arguments === 'DOKTER') {
            if (session()->get('role') !== 'DOKTER') {
                return redirect()->to('/');
            }
        }

        if ($arguments === 'APOTEKER') {
            if (session()->get('role') !== 'APOTEKER') {
                return redirect()->to('/');
            }
        }

        if ($arguments === 'KLINIK') {
            if (session()->get('role') !== 'KLINIK') {
                return redirect()->to('/');
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
