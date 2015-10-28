<html>
<head>
<title>MadGraph 5 Processes</title>
<link rel="stylesheet" type="text/css" href="pythia.css"/>
<link rel="shortcut icon" href="pythia32.gif"/>
</head>
<body>

<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target :((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text"))
{return false;}
}

document.onkeypress = stopRKey;
</script>
<?php
if($_POST['saved'] == 1) {
if($_POST['filepath'] != "files/") {
echo "<font color='red'>SETTINGS SAVED TO FILE</font><br/><br/>"; }
else {
echo "<font color='red'>NO FILE SELECTED YET.. PLEASE DO SO </font><a href='SaveSettings.php'>HERE</a><br/><br/>"; }
}
?>

<form method='post' action='MadGraph5Processes.php'>
 
<h2>MadGraph 5 Processes</h2> 
 
By far the easiest way to implement new processes into PYTHIA 8 is 
by using the matrix-element generator MadGraph 5. This program has 
an option to output the results of a matrix-element calculation 
as a set of PYTHIA 8 C++ classes (plus further auxiliary code), 
that can then be linked and used as 
<?php $filepath = $_GET["filepath"];
echo "<a href='SemiInternalProcesses.php?filepath=".$filepath."' target='page'>";?>semi-internal</a> processes, 
meaning they are handled identically with normal internal ones. 
This way, MadGraph 5 can be used to implement processes from 
any model that can be written in  terms of a Lagrangian. Any 
<i>2 &rarr; 1</i>, <i>2 &rarr; 2</i> and <i>2 &rarr; 3</i> processes 
can be implemented, the limit being set by the absence of efficient 
phase space generator algorithms for higher multiplicities in 
PYTHIA. Features such as <i>s</i>-channel resonances are 
automatically implemented in the process classes.  Besides the process 
library and necessary model files, also an example main program is 
generated for each set of processes, which can be easily modified to 
perform the desired analyses. 
 
<p/> 
In order to create a PYTHIA 8 process library with MadGraph 5, first 
download the MadGraph 5 package from 
<a href="https://launchpad.net/madgraph5" target="page"> 
https://launchpad.net/madgraph5</a>, and untar the package. You can 
then specify the location of your <code>pythia81xx</code> directory 
in the file <code>input/mg5_configuration.txt</code>: 
<br/><code>pythia8_path = ./pythia81xx</code> 
<br/>The location can be either relative (to the directory 
<code>MadGraph5_v_x_x_x/.</code>) or absolute. 
 
<p/> 
For any model that is already implemented in the MadGraph 5 package, 
you can directly use the model. Start the MadGraph 5 interface 
<code>bin/mg5</code>, and do: 
<pre> 
import model model_name 
generate your_process_in_mg5_syntax 
add process your_next_process_in_mg5_syntax 
... 
output pythia8 [path_to_pythia81xx_directory] 
</pre> 
 
<p/> 
For examples of MG5 process syntax, please see 
<a href="http://madgraph.phys.ucl.ac.be/EXAMPLES/example_mg5.html" 
target="page">http://madgraph.phys.ucl.ac.be/EXAMPLES/example_mg5.html</a> 
or type <code>help generate</code>. If you specified the path to the 
<code>pythia81xx</code> directory in the <code>mg5_configuration</code> 
file, you do not need to enter it in the <code>output</code> command. 
 
<p/> 
If your preferred model is found on the FeynRules model wiki page, 
<a href="http://feynrules.irmp.ucl.ac.be/wiki/ModelDatabaseMainPage" 
target="page">http://feynrules.irmp.ucl.ac.be/wiki/ModelDatabaseMainPage</a>, 
download the UFO (Universal FeynRules Output) tar file for the model, 
untar in the <code>models/</code> directory, and use as above. 
 
<p/> 
If you want to implement a new model which has not yet been implemented, 
you can do this either using the Mathematica package FeynRules (see 
<a href="http://feynrules.irmp.ucl.ac.be/" target="page"> 
http://feynrules.irmp.ucl.ac.be/</a>) or directly edit the UFO model 
files of the most similar model in the <code>models/</code> directory. 
 
<p/> 
The resulting output from the <code>output pythia8</code> command is: 
<ul> 
<li>A process directory <code>Processes_modelname</code> with the 
model information and the files needed for all processes defined for 
this model, placed in the <code>pythia81xx</code> main directory. 
The model files are <code>Parameters_modelname.h/cc</code> and 
<code>HelAmps_modelname.h/cc</code>, and the process files for each 
process class (with the same mass, spin and color of the initial/final 
state particles) are called <code>Sigma_modelname_processname.h/cc</code>. 
The directory also contains a <code>makefile</code> and a model parameter 
file <code>param_card_modelname.dat</code>.</li> 
<li>An example main program in the directory <code>examples/</code> 
(in the <code>pythia81xx</code> main directory) called 
<code>main_modelname_N.cc</code> and a corresponding makefile 
<code>Makefile_modelname_N</code>. This main program links in the 
process classes in the process directory described above. To run the 
example main program, just go to the <code>examples/</code> 
directory and run 
<br/><code>make -f Makefile_modelname_N</code> 
<br/>or run <code>launch</code> directly inside the MadGraph 5 
command line interface.</li> 
</ul> 
 
<p/> 
Note that in order for PYTHIA 8 to be able to automatically decay any 
new particles, it is necessary to specify the branching ratios of the 
particles in the <code>param_card</code> file, see 
[<a href="Bibliography.php" target="page">Ska04,Alw07</a>] for details. 
 
<p/> 
For further technical details, please see the MadGraph 5 release paper 
[<a href="Bibliography.php" target="page">Alw11</a>] and the 
<?php $filepath = $_GET["filepath"];
echo "<a href='SemiInternalProcesses.php?filepath=".$filepath."' target='page'>";?>semi-internal</a> processes page. 
 
<p/> 
Of course, as with MadGraph 4, MadGraph 5 can also output 
files of parton-level events according to the 
<?php $filepath = $_GET["filepath"];
echo "<a href='LesHouchesAccord.php?filepath=".$filepath."' target='page'>";?>LHEF</a> standard, 
that can be read in and processed further by PYTHIA 8. 
The advantage is that then the MadGraph 5 phase space generator 
can be used, which opens up for processes with more than three 
particles in the final state. The disadvantages are that it is less 
easy to mix and match with existing PYTHIA processes, and that one 
needs to regenerate and store large LHEF files for different 
kinematics cuts or parameter values. 
 
<p/> 
Please cite the MadGraph 5 release paper [<a href="Bibliography.php" target="page">Alw11</a>] if you use 
MadGraph 5 to generate process libraries for PYTHIA 8. 
 
</body>
</html>
 
<!-- Copyright (C) 2015 Torbjorn Sjostrand --> 
