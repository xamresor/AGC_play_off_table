<style>
    div.button {
        margin: 1rem;
    }
    button {
        width: -webkit-fill-available;
    }
</style>
<div class="button">
    <form action="{{$action ?? ''}}" method="POST" style="display: inline" class="">
        @csrf
        @method('POST')
        <div>
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fa fa-check">{{$text ?? ''}}</i>
            </button>
        </div>
    </form>
</div>
