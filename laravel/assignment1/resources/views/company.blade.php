@extends('layouts.app')

@section('title', "Company")

@section('content')

    <div class="panel panel-default panel-form">
        <form action="/company/add" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Enter Company Name:</label>
                <input class="form-control" type="text" name="name" id="txtName">
            </div>

            <div class="form-group">
                <label for="country">Enter Country:</label>
                <input class="form-control" type="text" name="country" id="txtCountry">
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><h2>Company List</h2></div>
        <div class="panel-body">
            @if (count($companyList) > 0)
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($companyList as $company)
                            @if ($company->deleted_at == null)
                                <tr>
                                    <td>{{$company->id}}</td>
                                    <td>{{$company->name}}</td>
                                    <td>{{$company->country}}</td>
                                    <td>
                                        <form action="/company/delete/{{$company->id}}" method="POST">
                                            {{ csrf_field() }}
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection