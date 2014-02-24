						<div id="taskForm">
							<input type="text" name="task" class="task"/>
							<input type="submit" value="Add" id="addButton" />
						</div>
						<div id="taskInfo">
							<span id="categories">
								<input name="taskCategory" type="radio" value="worktask" />worktask
								<input name="taskCategory" type="radio" value="meeting" />meeting
								<input name="taskCategory" type="radio" value="personal" />personal
								<input name="taskCategory" type="radio" value="default" checked="checked" />etc
							</span>
							start
							<select name="startHour">
								<?php
									for($i=0;$i<24;$i++){
										echo "<option>".sprintf("%02d",$i)."</option>";
									}
								?>
							</select>
							<select name="startMinutes">
								<?php
									for($i=0;$i<60;$i+=10){
										echo "<option>".sprintf("%02d",$i)."</option>";
									}
								?>
							</select>
							end
							<select name="endHour">
								<?php
									for($i=0;$i<24;$i++){
										echo "<option>".sprintf("%02d",$i)."</option>";
									}
								?>
							</select>
							<select name="endMinutes">
								<?php
									for($i=0;$i<60;$i+=10){
										echo "<option>".sprintf("%02d",$i)."</option>";
									}
								?>
							</select>
						</div>
