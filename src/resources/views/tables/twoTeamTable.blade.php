<?php
?>

<table class="teams small">
    <tbody>
        <tr>
            <td>{{$teamAName}}</td>
            <td rowspan="3">
                <b>Winner: </b>
                {{$winnerName}}
            </td>
        </tr>
        <tr>
            <td style="border: none">
                -{{$score}}-
            </td>
        </tr>
        <tr>
            <td>{{$teamBName}}</td>
        </tr>
    </tbody>
</table>
