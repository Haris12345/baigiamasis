@extends('multiauth::layouts.summary')
@section('print_sheet')
    <p><b>
        <center>ALYTAUS KOLEGIJA</center>
        <center>INFORMACIJOS IR RYŠIŲ TECHNOLOGIJŲ FAKULTETAS</center>
        <center>PAŽANGUMO SUVESTINĖ</center>
        <center>{{$studies_program_name->studies_program_name}} {{$subjects[0]->group}}</center>
    </b></p>
    
    
    <table>
        <tr>
            <th style="padding-left: 1px; padding-right: 1px" width="10px">Eil. Nr.</th>
            <td style="vertical-align: middle; padding-left: 3px; padding-right: 3px">Vardas, pavardė</td>
            @foreach($subjects as $subject)
                <td><span>{{$subject->subject_name}}</span></td>
            @endforeach
            <td><span><b>Slenkstinis vidurkis</b></span></td>
        </tr>
        <tr>
            <td></td>
            <th>Semestras</th>
            @foreach($subjects as $subject)
                <th style="padding-left: 1px; padding-right: 1px">{{$subject->semester}}</th>              
            @endforeach
            <th></th>
        </tr>
        <tr>
            <td></td>
            <th>Kreditai</th>
            @foreach($subjects as $subject)
                <th style="padding-left: 1px; padding-right: 1px">{{$subject->credits}}</th>             
            @endforeach
            <th></th>
        </tr>
        
        <?php $i = 0; ?>
        @foreach($students as $student)
            <tr>
                <th style="padding-left: 1px; padding-right: 1px">{{$i+1}}</th>
                <th style="padding-left: 1px; padding-right: 1px">{{$student->name}} {{$student->last_name}}</th>
                <?php $k = 0; ?>
                @foreach($subjects as $subject)
                    <?php $exam_occured = false; ?>
                    @foreach($all_exams as $exam)
                        @if(($exam->subject_code == $subject->subject_code && $exam->semester == $subject->semester && $exam->student_id == $student->id))
                            @if(substr($exam->mark, 0, 2) == "Ne")
                                <td style="background-color: red">n</td>
                            @else
                                <td>{{substr($exam->mark, 0, 2)}}</td>
                            @endif
                            <?php $k++; ?>
                            <?php $exam_occured = true; ?>
                        @endif 
                    @endforeach
                    @if($exam_occured == false)
                        <td></td>
                    @endif 
                @endforeach
                <th style="padding-left: 1px; padding-right: 1px">
                    @if(isset($average[$i]))
                        {{$average[$i]}}
                    @endif
                </th>
            </tr>
            <?php $i++; ?>
        @endforeach
    </table>
       
@endsection

