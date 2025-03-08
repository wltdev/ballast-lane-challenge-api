<?php

namespace App\Virtual;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Ballast Lane Challenge API Documentation",
 *      description="API documentation for Ballast Lane Challenge application",
 *      @OA\Contact(
 *          email="mdias.welinton@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Ballast Lane Challenge API Server"
 * )
 *
 * @OA\Server(
 *      url="http://localhost:8083",
 *      description="Docker container"
 * )
 *
 * @OA\Tag(
 *     name="Ballast Lane Challenge",
 *     description="API Endpoints of Ballast Lane Challenge"
 * )
 */
class Swagger {}
