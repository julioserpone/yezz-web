 @php
    $e = session('error');
    $e = $e ? Html::ul($e->all()) : '<p>'.$e.'</p>';
    $m = session('msg');
    $m = $m ? (is_array($m) ? Html::ul($m) : '<p>'.$m.'</p>' ) : '';
 @endphp
 	@if(session('msg'))
    <script type="text/javascript">
        $(document).ready(function () {
			
			showNotify('success',"{!! trans('message.success_alert_title') !!}","{!! $m !!}");

        });
    </script>
    @endif
    @if(session('error'))
    <script type="text/javascript">
        $(document).ready(function () {

        	showNotify('error',"{!! trans('message.error_alert_title') !!}",'{!! $e !!}');
        });
    </script>
    @endif
