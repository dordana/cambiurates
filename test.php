<?php
$descr = array(
    0 => array(
            'pipe',
                    'r'
                        ) ,
                            1 => array(
                                    'pipe',
                                            'w'
                                                ) ,
                                                    2 => array(
                                                            'pipe',
                                                                    'w'
                                                                        )
                                                                        );
                                                                        $pipes = array();
                                                                        $process = proc_open("ls -l", $descr, $pipes);
                                                                        if (is_resource($process)) {
                                                                            while ($f = fgets($pipes[1])) {
                                                                                    echo "-pipe 1--->";
                                                                                            echo $f;
                                                                                                }
                                                                                                    fclose($pipes[1]);
                                                                                                        while ($f = fgets($pipes[2])) {
                                                                                                                echo "-pipe 2--->";
                                                                                                                        echo $f;
                                                                                                                            }
                                                                                                                                fclose($pipes[2]);
                                                                                                                                    proc_close($process);
                                                                                                                                    }
                                                                                                                                    ?>