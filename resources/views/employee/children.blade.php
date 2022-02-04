@foreach ($employees as $employee)
    {
    @if (!count($employee->subCategory))
        id: {{ $employee->id }},
    @endif
        text: "{{ $employee->name }}",
    @if (count($employee->children))
        inc: [@include('employee.children',['employees' => $employee->children])]
    @endif
    },
@endforeach
