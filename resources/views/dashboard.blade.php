@extends('sidebars.dashboardSidebar')

@section('body')
	<form onsubmit="return send();">
		<div class="form-group">
			<label for="exampleInputEmail1">Git link:</label>
			<input type="text" id="link" class="form-control" pattern="^https:\/\/github.com\/[A-Za-z0-9\-]+\/[A-Za-z0-9\-]+.git$" title="examle: https://github.com/example/example.git" required value="https://github.com/greencity1993/VAS.git">
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">Regular expression:</label>
			<input type="text" id="regularExpression"  class="form-control" required value=".*\\/ex02\\/.*.*">
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
    <div id="result">
        <div class="modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <center><img src="{{ asset('img/gears.gif' )}}"></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        function send(){
            $('#exampleModalCenter').modal('show');
            $.ajax({
                type: "POST",
                url: "/dashboard/juliaUsage",
                data: { 
                    link : $( "#link" ).val(),
                    regularExpression : $( "#regularExpression" ).val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result){
                    $('#exampleModalCenter').modal('hide');
                    $( "#result" ).append( result );

                }
            });
            return false;
        }
    </script>
@endsection
