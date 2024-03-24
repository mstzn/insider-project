<?php

it('Exception should throw and status should be 422', function () {

    $exceptionMessage = 'some exception excepted';
    $this->expectException(\App\Exceptions\TeamCountIsNotEvenException::class);
    $this->expectExceptionCode(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    $this->expectExceptionMessage($exceptionMessage);

    throw new \App\Exceptions\TeamCountIsNotEvenException($exceptionMessage);

});
