<?php
$con =   new MySQLi("localhost","root","","autovermietung");
if($con->connect_error){
    echo "Fehler bei  der Verbindung" . mysqli_connect_error();
    exit();
}
$erg = $con->query("SELECT * FROM mietvertraege")
echo "<center><table>"
echo"<thead><tr><th>Mietvertragsnummer</th><th>Miete-Anfang</th> <th>Miete-Ende</th><th>Zahlart</th><th>Kosten</th><th>Ausgangszustand</th></tr></thead><tbody>";
while($zeile = $erg->fetch_array())
{
    echo"<tr>
            <td>[$zeile['mietvertragID']</td>
            <td>[$zeile['status']</td>
            <td>[$zeile['mietdauerTage']</td>
            <td>[$zeile['mietgebuehr']</td>
            <td>[$zeile['zahlart']</td>
            <td>[$zeile['tarif']</td>
            <td>[$zeile['abholstation']</td>
            <td>[$zeile['rueckgabestation']</td>
            <td>[$zeile['vertragID']</td>
            <td>01.01.2022</td>
            <td>05.05.2022</td>
        </tr>";
}

echo"</tbody>
</table>
</center>";
?>