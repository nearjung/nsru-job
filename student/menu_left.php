<div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">ตัวเลือกหางาน</li>
                                <li>
                                    <a href="../student/">
                                        <i class="metismenu-icon pe-7s-science"></i>
                                        งานทั้งหมด
                                    </a>
                                </li>
								<li>
                                    <a href="work.php?b=6">
                                        <i class="metismenu-icon pe-7s-science"></i>
                                        จับคู่งานตามสาขาเรา
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-rocket"></i>
                                        งานตามสายอาชีพ
										<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
										<?php
										$catalog_sql = $sql->prepare("EXEC dbo.WorkCatagoryList");
										$catalog_sql->execute();
										while($catalog = $catalog_sql->fetch(PDO::FETCH_ASSOC)){
                                        echo '<li>
                                            <a href="work.php?id='.$catalog['work_id'].'">
                                                <i class="metismenu-icon"></i>';
											if(strlen($catalog['name']) > 25){
                                                echo ''.mb_substr($catalog['name'],0,25,'UTF-8').'...';
											} else {
                                                echo ''.mb_substr($catalog['name'],0,25,'UTF-8').'';
											}
                                            echo '</a>
                                        </li>';
										}
										?>
										
									</ul>
                                </li>
								
                                <li>
                                    <a href="work.php?b=1">
                                        <i class="metismenu-icon pe-7s-cash"></i>
                                        งานตามฐานเงินเดือน
										<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
										<li>
											<a href="work.php?b=2">
												<i class="metismenu-icon pe-7s-cart"></i>
												ต่ำกว่า 10,000 บาท
											</a>
										</li>
										<li>
											<a href="work.php?b=3">
												<i class="metismenu-icon pe-7s-cart"></i>
												10,000 - 20,000 บาท
											</a>
										</li>
										<li>
											<a href="work.php?b=4">
												<i class="metismenu-icon pe-7s-cart"></i>
												20,000 - 45,000 บาท
											</a>
										</li>
										<li>
											<a href="work.php?b=5">
												<i class="metismenu-icon pe-7s-cart"></i>
												45,000 บาท ขึ้นไป
											</a>
										</li>
									</ul>
                                </li>
								
                                <li class="app-sidebar__heading">จัดการงาน</li>
                                <li>
                                    <a href="jobcart.php">
                                        <i class="metismenu-icon pe-7s-cart"></i>
                                        งานที่คุณสนใจ
                                    </a>
                                </li>
                                <li>
                                    <a href="jobstatus.php">
                                        <i class="metismenu-icon pe-7s-display2"></i>
                                        สถานะการสมัครงาน
                                    </a>
                                </li>
								
								<li class="app-sidebar__heading">ข้อมูลส่วนตัว</li>
                                <li>
                                    <a href="myresume.php">
                                        <i class="metismenu-icon pe-7s-portfolio"></i>
                                        เรซูเมของฉัน
                                    </a>
                                </li>
                                <li>
                                    <a href="setting.php">
                                        <i class="metismenu-icon pe-7s-tools"></i>
                                        ตั้งค่าบัญชี
                                    </a>
                                </li>
                        </div>
</div>