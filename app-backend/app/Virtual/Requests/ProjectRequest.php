<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="Project Request",
 *     description="Project request",
 *     type="object",
 *     required={"name", "description"}
 * )
 */

class ProjectRequest
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="Name of the project",
     *     type="string",
     *     example="Project 1"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="description",
     *     description="Description of the project",
     *     type="string",
     *     example="Description of project 1"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *     title="user_id",
     *     description="ID of the user",
     *     type="integer",
     *     example=1
     * )
     *
     * @var int
     */
    public $user_id;

    /**
     * @OA\Property(
     *     title="tasks",
     *     description="Tasks of the project",
     *     type="array",
     *     @OA\Items(
     *         ref="#/components/schemas/Task"
     *     )
     * )
     *
     * @var array
     */
    public $tasks;
}
