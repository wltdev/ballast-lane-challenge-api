<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Project",
 *     description="Project model",
 *     @OA\Xml(
 *         name="Project"
 *     )
 * )
 */

class Project
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="id",
     *     type="integer",
     *     example=1
     * )
     *
     * @var int
     */
    public int $id;

    /**
     * @OA\Property(
     *     title="user_id",
     *     description="user_id",
     *     type="integer",
     *     example=1
     * )
     *
     * @var int
     */
    public int $user_id;


    /**
     * @OA\Property(
     *     title="name",
     *     description="name",
     *     type="string",
     *     example="Project 1"
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="description",
     *     description="description",
     *     type="string",
     *     example="Description of project 1"
     * )
     *
     * @var string
     */
    public string $description;

    /**
     * @OA\Property(
     *     title="created_at",
     *     description="created_at",
     *     type="string",
     *     format="date-time",
     *     example="2023-01-01T00:00:00.000000Z"
     * )
     *
     * @var string
     */
    public string $created_at;

    /**
     * @OA\Property(
     *     title="updated_at",
     *     description="updated_at",
     *     type="string",
     *     format="date-time",
     *     example="2023-01-01T00:00:00.000000Z"
     * )
     *
     * @var string
     */
    public string $updated_at;

    // tasks
    /**
     * @OA\Property(
     *     title="tasks",
     *     description="tasks",
     *     type="array",
     *     @OA\Items(
     *         ref="#/components/schemas/Task"
     *     )
     * )
     *
     * @var array
     */
    public array $tasks;
}
