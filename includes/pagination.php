<div class="container-fluid w-25 my-container">
                <nav class="navbar navbar-dark p-2 navbar-expand-lg tile-color">
                    <?php
                        $prevPage = 1;
                        $nextPage = $numOfPages;
                        if($pageNum>2) $prevPage=$pageNum-1;
                        if($pageNum<$numOfPages-1) $nextPage=$pageNum+1;
                    ?>
                <a class="navbar-brand" href="index.php?page=<?php echo $prevPage; ?>">&#8678;</a>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav pager">
                            <?php
                            if($pageNum<=3){
                                $start=1;
                            }
                            else{
                                $start=$pageNum-2;
                            }

                            $end=$start+4;

                            if($end>$numOfPages){
                                $end=$numOfPages;
                            }

                            for($i=$start; $i<=$end; $i++){
                                if($pageNum == $i){
                                    echo "<a class='nav-item nav-link active current-page px-3' href='index.php?page=$i'>$i</a>";
                                }else{
                                    echo "<a class='nav-item nav-link active px-3' href='index.php?page=$i'>$i</a>";
                                }
                                
                            }
                            ?>
                        </div>
                    </div>
                    <a class="navbar-brand" href="index.php?page=<?php echo $nextPage; ?>">&#8680;</a>
                </nav>
            </div>