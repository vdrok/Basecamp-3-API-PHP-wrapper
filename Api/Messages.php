<?php
namespace Basecamp\Api;

/**
 * Messages API.
 *
 * @link https://github.com/basecamp/bcx-api/blob/master/sections/messages.md
 */
class Messages extends AbstractApi
{
    /**
     * Specified message.
     *
     * @param integer $projectId
     * @param integer $messageId
     *
     * @return object
     */
    public function show($projectId, $messageId)
    {
        $data = $this->get('/buckets/' . $projectId . '/messages/' . $messageId . '.json');

        return $data;
    }


    /**
     * All Messages for a given project and message
     *
     * @param integer $projectId            
     * @param integer $messageboardId            
     *
     * @return array
     */
    public function allByMessages($projectId, $messageboardId, array $params = []) // Updated 2018-6-21
    {
        // /projects/1/todolists/1/todos
        $data = $this->get('/buckets/' . $projectId . '/message_boards/' . $messageboardId . '/messages.json', $params);
        
        return $data;
    }

    /**
     * Create message.
     *
     * @param integer $projectId
     * @param array $params
     *
     * @return object
     */
    public function create($projectId, $messageId, array $params)
    {
        $data = $this->post('/buckets/' . $projectId .  '/message_boards/' . $messageId .'/messages.json', $params);

        return $data;
    }

    /**
     * Update message.
     *
     * @param integer $projectId
     * @param integer $messageId
     * @param array $params
     *
     * @return object
     */
    public function update($projectId, $messageId, array $params)
    {
        $data = $this->put('/buckets/' . $projectId . '/messages/' . $messageId . '.json', $params);

        return $data;
    }

    /**
     * Delete message.
     *
     * @param integer $projectId
     * @param integer $messageId
     *
     * @return object
     */
    public function remove($projectId, $messageId)
    {
        $data = $this->delete('/buckets/' . $projectId . '/recordings/' . $messageId . '/status/trashed.json');

        return $data;
    }
}
