<ul id="myUL">
    <li>
        <span class="caret">Permission</span>
        <ul class="nested">

            @php $header = '';@endphp
            @foreach ($permissions as $key => $permission)
            @php
            $model = explode('-', $permission->name)[0];
            if ($header != $model) {
            $header = $model;
            }
            @endphp

            <li><span class="caret">{{$header}}</span>
                <ul class="nested">
                    <li>Black Tea</li>
                    <li>White Tea</li>
                </ul>
            </li>

            @endforeach
        </ul>
    </li>
</ul>
