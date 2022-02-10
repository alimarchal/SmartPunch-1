@foreach($subcategories as $subcategory)
    <ul>
        <li><a href="#"  style="color: blue; ">{{$subcategory->name}}
                - <span style="color: black;">Designation:</span>
                <span style="color: red;">{{$subcategory->designation}} </span>
                @if(!empty($category->office))
                    - <span style="color: green;">Office: {{$subcategory->office->name}}</span>
                @endif
            </a>
        </li>
        @if(count($subcategory->subcategory))
            @include('teamview.subCategoryList',['subcategories' => $subcategory->subcategory])
        @endif
    </ul>
@endforeach
