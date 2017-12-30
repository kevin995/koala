@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3>新增课程</h3>
                {{ Form::open(array('url' => 'courses', 'class' => 'form-horizontal')) }}
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" placeholder="" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="speaker" class="col-sm-2 control-label">主讲人</label>
                        <div class="col-sm-10">
                            <select name="speaker" class="form-control" id="speaker">
                                <option value="">请选择</option>
                                @foreach($users as $user)
                                    <option {{ old('speaker') == $user['id'] ? 'selected' : '' }} value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('speaker'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('speaker') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location" class="col-sm-2 control-label">地点</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="location" id="location" placeholder="" value="{{ old('location') }}">
                            @if ($errors->has('location'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-sm-2 control-label">时间</label>
                        <div class="col-sm-10">
                            <input size="16" type="text" class="form-control" name="date" id="date" value="{{ old('date') }}">
                            <span class="add-on"><i class="icon-th"></i></span>
                            @if ($errors->has('date'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script type="text/javascript">
        $("#date").datetimepicker({
            language: 'zh-CN',
            autoclose: true,
            format: "yyyy/mm/dd hh:ii"
        });
    </script>
@endsection