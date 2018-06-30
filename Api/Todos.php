<?php
namespace Basecamp\Api;

/**
 * Todos API.
 *
 * @link https://github.com/basecamp/bcx-api/blob/master/sections/todos.md
 */
class Todos extends AbstractApi
{

    /**
     * Get todo set.
     *
     * @param integer $projectId            
     * @param integer $todosetId            
     *
     * @return object
     */
    public function showTodoset($projectId, $todosetId) // Updated 2018-6-21
    {
        $data = $this->get('/buckets/' . $projectId . '/todosets/' . $todosetId . '.json');
        
        return $data;
    }

    /**
     * Get todo.
     *
     * @param integer $projectId            
     * @param integer $todoId            
     *
     * @return object
     */
    public function show($projectId, $todoId) // Updated 2018-6-21
    {
        $data = $this->get('/buckets/' . $projectId . '/todos/' . $todoId . '.json');
        
        return $data;
    }

    /**
     * All todos for a given project and todolist
     *
     * @param integer $projectId            
     * @param integer $todolistId            
     *
     * @return array
     */
    public function allByTodolist($projectId, $todolistId, array $params = []) // Updated 2018-6-21
    {
        // /projects/1/todolists/1/todos
        $data = $this->get('/buckets/' . $projectId . '/todolists/' . $todolistId . '/todos.json', $params);
        
        return $data;
    }

    /**
     * Create todo.
     *
     * @param integer $projectId            
     * @param integer $todolistId            
     * @param array $params            
     *
     * @return object
     */
    public function create($projectId, $todolistId, array $params)  // Updated 2018-6-21
    {
        $data = $this->post('/buckets/' . $projectId . '/todolists/' . $todolistId . '/todos.json', $params);
        
        return $data;
    }

    /**
     * Update todo.
     *
     * @param integer $projectId            
     * @param integer $todoId            
     * @param array $params            
     *
     * @return object
     */
    public function update($projectId, $todoId, array $params) // Updated 2018-6-21
    {
        $data = $this->put('/buckets/' . $projectId . '/todos/' . $todoId . '.json', $params);
        
        return $data;
    }
    /**
     * Complete todo.
     *
     * @param integer $projectId            
     * @param integer $todoId            
     * @param array $params            
     *
     * @return object
     */
    public function complete($projectId, $todoId, array $params = [])  // Updated 2018-6-21
    {
        $data = $this->post('/buckets/' . $projectId . '/todos/' . $todoId . '/completion.json', $params);
        
        return $data;
    }

    /**
     * Uncomplete todo.
     *
     * @param integer $projectId            
     * @param integer $todoId            
     * @param array $params            
     *
     * @return object
     */
    public function uncomplete($projectId, $todoId, array $params = [])  // Updated 2018-6-21
    {
        $data = $this->delete('/buckets/' . $projectId . '/todos/' . $todoId . '/completion.json', $params);
        
        return $data;
    }

    /**
     * Reposition todo.
     *
     * @param integer $projectId            
     * @param integer $todoId            
     * @param array $params            
     *
     * @return object
     */
    public function position($projectId, $todoId, array $params) // Updated 2018-6-21
    {
        $data = $this->put('/buckets/' . $projectId . '/todos/' . $todoId . '/position.json', $params);
        
        return $data;
    }
    /**
     * Delete todo.
     *
     * @param integer $projectId            
     * @param integer $todoId            
     *
     * @return object
     */
    public function remove($projectId, $todoId) // Updated 2018-6-21
    {
        $data = $this->delete('/buckets/' . $projectId . '/recordings/' . $todoId . '/status/trashed.json');
        
        return $data;
    }
}
