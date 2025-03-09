<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Task",
 *     description="Task model",
 *     @OA\Xml(
 *         name="Task"
 *     )
 * )
 */

class Task
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
     *     title="project_id",
     *     description="project_id",
     *     type="integer",
     *     example=1
     * )
     *
     * @var int
     */
    public int $project_id;

    /**
     * @OA\Property(
     *     title="title",
     *     description="title",
     *     type="string",
     *     example="Task 1"
     * )
     *
     * @var string
     */
    public string $title;

    /**
     * @OA\Property(
     *     title="status",
     *     description="status",
     *     type="string",
     *     example="pending"
     * )
     *
     * @var string
     */
    public string $status;

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
}
