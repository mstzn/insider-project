<?php

it('teams endpoint returns success response', function () {
    $response = $this->get('/api/teams');

    $response->assertStatus(200);
});
