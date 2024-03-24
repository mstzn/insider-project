<?php

it('Exception should throw and status should be 400', function () {

    $exceptionMessage = 'some exception excepted';
    $this->expectException(\App\Exceptions\AllWeeksPlayedException::class);
    $this->expectExceptionCode(\Illuminate\Http\Response::HTTP_BAD_REQUEST);
    $this->expectExceptionMessage($exceptionMessage);

    throw new \App\Exceptions\AllWeeksPlayedException($exceptionMessage);

});
