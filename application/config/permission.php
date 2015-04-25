<?php  
/**
1. 超级管理员 
2. IT系统人员
3. 总经理
4. 副总经理
5. 部门经理
6. 项目经理
8. 普通员工
9. 人事管理员
10. 市场管理员
11. 经理管理员

1. 超级管理员 
2. 人事管理员
3. 市场管理员
4. 经理管理员
5. 普通用户
**/

/**
 * 1. 所有url，默认超级管理人员具有所有权限, 无需配置超级管理员权限。
 * 2. 只有对权限有限制的url需要进行配置。
 */

/**
 * 注意所有配置的url都必须全小写。
 **/
$rolePermission = array(
                        '/employee/add' => '1,2',
                        '/employee/updatestatus' => '1,2',
                        '/employee/update' => '1,2',
                        '/employee/del' => '1,2',

                        '/project/add' => '1,3,4',
                        '/project/updatebasic' => '1,3,4',
                        '/project/appendtimes' => '1,4',
                    );
$config['permission'] = array('role'=>$rolePermission);
