<?php

it('Exception should throw and status should be 404', function () {

    $exceptionMessage = 'some exception excepted';
    $this->expectException(\App\Exceptions\NoActiveFixtureFoundException::class);
    $this->expectExceptionCode(\Illuminate\Http\Response::HTTP_NOT_FOUND);
    $this->expectExceptionMessage($exceptionMessage);

    throw new \App\Exceptions\NoActiveFixtureFoundException($exceptionMessage);

});
