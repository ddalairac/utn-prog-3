<?php

namespace App\Utils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface iCRUD {
    public function getAll(Request $request, Response $response);
    public function getOne(Request $request, Response $response);
    public function add(Request $request, Response $response);
    public function update(Request $request, Response $response);
    public function delete(Request $request, Response $response);
}