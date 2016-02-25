@extends('frontend.subscribe.common')

@section('templateBody')
    <div class="formstatus error">下面有错误</div>
    <form action="/subscribe" method="POST">
        {{ csrf_field() }}
        <div id="mergeTable" class="mergeTable">
            <div class="mergeRow dojoDndItem mergeRow-email" id="mergeRow-0">
                <label for="MERGE0">Email地址 <span class="req asterisk">*</span></label>

                <div class="field-group">
                    <input type="email" name="email" id="MERGE0" size="25" value="{{ $subscribeUser->email or $email }}">

                    <div class="feedback error">
                        <div class="errorText">
                            @section('errorText') {{ $errorText or ''}} @show
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="submit_container clear">
            <input type="submit" class="button" value="确定订阅">
        </div>
    </form>
@stop
