<?php
/**
 * module代码自动生成器
 * @author zhengshufa
 * @date 2015-10-13
 *
 */

class codemaker {
    //模型名
    private $module;
    //Controller/Model名称时用到，通常与数据表名一致
    private $name;
    //表名
    private $table;
    //主键名称
    private $prikey;
    //设置的字段参数 array
    private $fields;
    
    //存储controller code string
    private $ctrlstr = '<?php ';
    //存储model code string
    private $modelstr = '<?php ';
    //存储view code string
    private $viewarr = array(
        'add'=>'',
        'edit'=>'',
        'lists'=>'',
        'show'=>''
    );
    private $datetime;
    //创建者
    private $author = 'zhengshufa';
    //是否有上传文件input
    private $has_file = false;
    //视图相对目录
    private $vdir = "";
    
    public function __construct($module = '', $model = '', $table = '', $prikey = '', $fields = array()){
        $this->module = $module;
        $this->name = $model;
        $this->table = $table;
        $this->prikey = $prikey;
        $this->fields = $fields;
        $this->datetime = date("Y-m-d H:i:s");
        
        $this->vdir = $module === $model?"":$model.'/';
        
        $this->ctrl();
        $this->model();
        $this->view();
    }
    
    /**
     * 生成controller文件
     */
    public function ctrl(){
       $this->ctrlstr .= "defined('AFA') or die('No AFA PHP Framework!');\n\n";
       $this->ctrlstr .= $this->note($this->name.'模型控制器', $this->author, $this->datetime);
       $this->ctrlstr .= "class {$this->name}_Controller extends Controller{\n\n";
       $this->ctrlstr .= "private \$vdir = '{$this->vdir}';\n\n";
       
       foreach ($this->fields as $arr){
           if (in_array($arr['type'], array('checkbox','radio','select'))){
               $this->ctrlstr .= "private \${$arr['name']}_arr = '".serialize($arr['type_extend'])."';\n\n";
           }
       }
       
       $this->action('add');
       $this->action('delete');
       $this->action('edit');
       $this->action('lists');
       $this->action('show');
       
       $this->ctrlstr .= "}\n";
       return $this->ctrlstr;
    }    
    
    /**
     * 生成Model文件
     */
    public function model(){
        $this->modelstr .= "defined('AFA') or die('No AFA PHP Framework!');\n\n";
        $this->modelstr .= $this->note($this->name.'模型', $this->author, $this->datetime);
        $this->modelstr .= "class {$this->name}_Model extends Model{\n\n";
        $this->modelstr .= "protected \$table = '{$this->table}';\n";
        $this->modelstr .= "protected \$primary = '{$this->prikey}';\n";
        $this->modelstr .= "protected \$fileds = array(\n";
        $this->modelstr .= "'{$this->prikey}'=>0,\n";
        
        foreach ($this->fields as $f){
            $this->modelstr .= "'{$f['name']}'=>'{$f['default_value']}',\n";
        }
        
        $this->modelstr .= ");\n}\n";
        return $this->ctrlstr;
    }
    
    /**
     * 生成View文件
     */
    public function view(){
        $this->viewarr['add'] = $this->view_header("新增".$this->name);
        $this->viewarr['add'] .= $this->view_add();
        $this->viewarr['add'] .= $this->view_footer();
        
        $this->viewarr['edit'] = $this->view_header("修改".$this->name);
        $this->viewarr['edit'] .= $this->view_edit();
        $this->viewarr['edit'] .= $this->view_footer();
        
        $this->viewarr['show'] = $this->view_header("展示".$this->name);
        $this->viewarr['show'] .= $this->view_show();
        $this->viewarr['show'] .= $this->view_footer();
        
        $this->viewarr['lists'] = $this->view_header("列表管理 ".$this->name);
        $this->viewarr['lists'] .= $this->view_lists();
        $this->viewarr['lists'] .= $this->view_footer();   
    }
    
    private function action($type = 'add'){
        switch ($type){
            case 'add':
                $this->ctrlstr .= $this->note("新增".$this->name);
                $this->ctrlstr .= "public function add_Action(){\n";
                $this->ctrlstr .= "if (input::post()){\n".
                                "\$post = input::post();\n".
                                "\${$this->name} = new {$this->name}_Model();\n".
                                "foreach (\$post as \$k=>\$v){\n".
                                    "\t\${$this->name}->\$k = is_array(\$v)?join(',', \$v):\$v;\n".
                                "}".
                                "\${$this->name}->save();\n".
                                "\$this->echomsg('新增成功!', 'lists');\n".
                                "}\n";
                
                $this->ctrlstr .= "\$view = &\$this->view;\n";
                $this->ctrlstr .= "\$view->set_view(\$this->vdir.'{$type}');\n";
                
                $this->ctrlstr .= "\$view->render();\n";
                $this->ctrlstr .= "}\n\n";
                break;
            case 'delete':
                $this->ctrlstr .= $this->note("删除".$this->name);
                $this->ctrlstr .= "public function delete_Action(\${$this->prikey}){\n";
                
                $this->ctrlstr .= "\${$this->name} = new {$this->name}_Model(\${$this->prikey});\n".
                                    "if(\${$this->name}->{$this->prikey}) {\n".
                                    "\${$this->name}->delete(\${$this->prikey});\n".
                                        "\$this->echomsg('删除成功!', '../lists');\n".
                                    "}else {\n".
                                        "\$this->echomsg('删除失败!', '../lists');\n".
                                    "}\n";
                                    
                $this->ctrlstr .= "}\n\n";
                break;
            case 'edit':
                $this->ctrlstr .= $this->note("修改".$this->name);
                $this->ctrlstr .= "public function edit_Action(\${$this->prikey}){\n";
                $this->ctrlstr .= "\${$this->name} = new {$this->name}_Model(\${$this->prikey});\n";
                $this->ctrlstr .= "if (input::post()){\n".
                    "\$post = input::post();\n".
                    "foreach (\$post as \$k=>\$v){\n".
                    "\t\${$this->name}->\$k = is_array(\$v)?join(',', \$v):\$v;\n".
                    "}".
                    "\${$this->name}->save();\n".
                    "\$this->echomsg('修改成功!', '../lists');\n".
                    "}\n";
                
                $this->ctrlstr .= "\$view = &\$this->view;\n";
                $this->ctrlstr .= "\$view->set_view(\$this->vdir.'{$type}');\n";
                $this->ctrlstr .= "\$view->{$this->name} = \${$this->name};\n";
                $this->ctrlstr .= "\$view->render();\n";
                $this->ctrlstr .= "}\n\n";
                break;
            case 'lists':
                $this->ctrlstr .= $this->note("列表管理 ".$this->name);
                $this->ctrlstr .= "public function lists_Action(){\n";
                $this->ctrlstr .= "\${$this->name} = new {$this->name}_Model();\n";
                $this->ctrlstr .= "\$view = &\$this->view;\n";
                $this->ctrlstr .= "\$view->set_view(\$this->vdir.'{$type}');\n";
                $this->ctrlstr .= "\$view->lists = \${$this->name}->lists('0,10');\n";
                
                $list_fields_arr = array("'{$this->prikey}'");
                foreach ($this->fields as $arr){
                    if ($arr['list_show']){
                        array_push($list_fields_arr, "'{$arr['name']}'");
                    }
                    if(in_array($arr['type'], array('checkbox','radio','select'))){
                        $this->ctrlstr .= "\$view->{$arr['name']}_arr = unserialize(\$this->{$arr['name']}_arr);\n";
                    }
                }
                $this->ctrlstr .= "\$view->list_fields_arr = array(".join(',', $list_fields_arr).");\n";
                
                $this->ctrlstr .= "\$view->render();\n";
                $this->ctrlstr .= "}\n\n";
                break;
            case 'show':
                    $this->ctrlstr .= $this->note("展示".$this->name);
                    $this->ctrlstr .= "public function show_Action(\${$this->prikey}){\n";
                    $this->ctrlstr .= "\${$this->name} = new {$this->name}_Model(\${$this->prikey});\n";
                
                    $this->ctrlstr .= "\$view = &\$this->view;\n";
                    $this->ctrlstr .= "\$view->set_view(\$this->vdir.'{$type}');\n";
                    $this->ctrlstr .= "\$view->{$this->name} = \${$this->name};\n";
                    
                    foreach ($this->fields as $arr){
                        if(in_array($arr['type'], array('checkbox','radio','select'))){
                            $this->ctrlstr .= "\$view->{$arr['name']}_arr = unserialize(\$this->{$arr['name']}_arr);\n";
                        }
                    }
                    
                    $this->ctrlstr .= "\$view->render();\n";
                    $this->ctrlstr .= "}\n\n";
                    break;
            default:
                break;
        }
    }
    
    /**
     * 生成注释
     */
    private function note($description, $author = false, $date = false){
        $str = "/**\n * {$description}\n"; 
        $str .= $author?"* @author ".$author."\n":"";
        $str .=  $date?"* @date {$this->datetime}\n":"";
        $str .= " */\n";
        return $str;
    }
    
    /**
     * 保存生成的结果
     */
    public function store(){
        //保存Controller文件
        $this->write(MODULEPATH.$this->module.'/controller/'.$this->name.'.php', $this->ctrlstr);
        
        //保存View视图文件
        $viewdir = MODULEPATH.$this->module.'/view/'.DIRECTORY_SEPARATOR.($this->module === $this->name?'':$this->name.DIRECTORY_SEPARATOR);
        //创建add视图
        $this->write($viewdir.'add.php', $this->viewarr['add']);
        //创建edit视图
        $this->write($viewdir.'edit.php', $this->viewarr['edit']);
        //创建lists视图
        $this->write($viewdir.'lists.php', $this->viewarr['lists']);
        //创建lists视图
        $this->write($viewdir.'show.php', $this->viewarr['show']);
        
        //报错Model文件
        $this->write(MODULEPATH.$this->module.'/model/'.$this->name.'.php', $this->modelstr);
    }
    
    private function view_header($description){
        $str = "<!DOCTYPE html>\n".
        "<html lang=\"zh-CN\">\n".
        "<head>\n".
        "<meta charset=\"UTF-8\">\n".
        "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n".
        "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n".
        "<title>{$description}</title>\n".
        "<link href=\"/static/bootstrap/css/bootstrap.css\" rel=\"stylesheet\">\n".
        "<link href=\"/static/bootstrap/css/bootstrap-theme.css\" rel=\"stylesheet\">\n".
        "<script src=\"/static/js/libs/jquery.min.js\"></script>\n".
        "<script src=\"/static/bootstrap/js/bootstrap.js\"></script>\n".
        "</head>\n".
        "<body>\n".
        "<div class=\"container\">\n".
        "<h2>{$description}</h2>\n";
        return $str;
    }
    
    private function view_footer(){
        $str = "<a href=\"javascript:history.go(-1);\">返回</a>\n</div>\n"."</body>\n"."</html>\n";
        return $str;
    }
    private function view_add(){
        $str = "<form method='post' __enctype__>\n";
        foreach ($this->fields as $v){
            $str .= $this->label($v);
        }
        $str .= "<button type=\"sumbit\" class=\"btn btn-default\">提交</button>\n";
        $str .= "</form>\n";
        
        $replace = ($this->has_file?"enctype=\"multipart/form-data\"":"");
        $str = str_replace('__enctype__', $replace, $str);
        
        $str .= $this->checkBoxCheck();
        
        return $str;
    }
    
    private function view_edit(){
        $str = "<form method='post' __enctype__>\n";
        foreach ($this->fields as $v){
            $str .= $this->label($v, true);
        }
        $str .= "<button type=\"sumbit\" class=\"btn btn-default\">提交</button>\n";
        $str .= "</form>\n";
        
        $replace = ($this->has_file?"enctype=\"multipart/form-data\"":"");
        $str = str_replace('__enctype__', $replace, $str);
        
        $str .= $this->checkBoxCheck();
        return $str;
    }
    
    private function view_show(){
        $str = "";
        foreach ($this->fields as $v){
            if (in_array($v['type'], array('radio','checkbox','select'))){
                $needle = $v['name'].'_arr';
                $str .= "<p><strong>{$v['cnname']}: </strong><?php echo F::findInArray(\${$this->name}->{$v['name']}, \$$needle);?></p>\n";
            }else{
                $str .= "<p><strong>{$v['cnname']}: </strong>"."<?php echo \${$this->name}->{$v['name']};?></p>\n";
            }
        }
        
        return $str;
    }
    
    private function view_lists(){
        $str = "<div class=\"table-responsive\">\n<table class=\"table table-bordered\">\n";
        
        $str .= "<thead>\n<tr>\n";
        $str .= "<th>".strtoupper($this->prikey)."</th>\n";
        foreach ($this->fields as $arr){
            if ($arr['list_show']){
                $str .= "<th>{$arr['cnname']}</th>\n";
            }
        }
        $str .= "<th>操作</th>";
        $str .= "</tr>\n</thead>\n<tbody>\n";
        $str .= "<?php foreach (\$lists as \$k=>\$arr):?>\n";
        $str .= "<tr>\n";
        $str .= "<?php foreach (\$arr as \$k=>\$v):?>\n";
        $str .= "<?php if(in_array(\$k, \$list_fields_arr)) {\n".
        "\$param = \$k.'_arr';\n".
        "if (isset($\$param) && is_array($\$param)){\n".
        "echo '<td>'.F::findInArray(\$v, $\$param).'</td>';\n".
        "}else{\n".
        " echo '<td>'.\$v.'</td>';}\n".
        "}\n?>";
        
        $str .= "<?php endforeach;?>\n";
        $str .= "<td><a href=\"show/<?php echo \$arr['{$this->prikey}'];?>\">查看</a> <a href=\"edit/<?php echo \$arr['{$this->prikey}'];?>\">修改</a> <a href=\"delete/<?php echo \$arr['{$this->prikey}'];?>\">删除</a> </td>";
        $str .= "</tr>\n<?php endforeach;?>\n</tbody>\n";
            
        $str .= "</table>\n</div>\n";
        
        $str .= "<a href=\"add\" class=\"col-md-1\">新增</a> ";
        return $str;
    }
    
    /**
     * 生成HTML字段
     * @param array $filed
     * @param boolean $is_edit  
     */
    private function label($filed, $is_edit = false){
        if (!$filed['is_edit']) return '';
        
        $str = '';
        switch ($filed['type']){
            case 'text':
            case 'password':
            case 'email':
            case 'date':
            case 'number':
            case 'tel':
            case 'datetime':
            case 'url':
                $str = "<div class=\"form-group\">\n";
                $str .= "<label name=\"{$filed['name']}\" for=\"input{$filed['name']}\" class=\"control-label\">{$filed['cnname']}</label>\n";
                $str .= "<input type=\"{$filed['type']}\" name=\"{$filed['name']}\" class=\"form-control\" id=\"input{$filed['name']}\" placeholder=\"{$filed['cnname']}\" value=\"".($is_edit?"<?php echo \${$this->name}->{$filed['name']};?>":"")."\"";
                if($filed['required']){ $str .= " required";}
                $str .= ">\n";
                $str .= "</div>\n";
                break;
            case 'file':
                $str = "<div class=\"form-group\">\n";
                $str .= "<label name=\"{$filed['name']}\" for=\"input{$filed['name']}\" class=\"control-label\">{$filed['cnname']}</label>\n";
                $str .= "<input type=\"{$filed['type']}\" name=\"{$filed['name']}\" id=\"input{$filed['name']}\"";
                if($filed['required']){ $str .= " required";}
                $str .= " />\n";
                $str .= "<p class=\"help-block\">头像尺寸 200 X 200</p>";
                $str .= "</div>\n";
                $this->has_file = true;
                break;
            case 'textarea':
                $str = "<div class=\"form-group\">\n";
                $str .= "<label name=\"{$filed['name']}\" for=\"input{$filed['name']}\" class=\"control-label\">{$filed['cnname']}</label>\n";
                $str .= "<textarea name=\"{$filed['name']}\" rows=\"5\" class=\"form-control\" id=\"input{$filed['name']}\" placeholder=\"{$filed['cnname']}\" ";
                if($filed['required']){ $str .= "required";}
                $str .= ">".($is_edit?"<?php echo \${$this->name}->{$filed['name']};?>":"")."</textarea>\n";
                $str .= "</div>\n";
                break;
            case 'checkbox':
                $str = "<div class=\"form-group\">\n";
                if($is_edit){
                    $str .= "<?php \$tmp_arr = explode(',', \${$this->name}->{$filed['name']});?>\n";
                }
                
                $i = 0;
                foreach ($filed['type_extend'] as $k=>$v){
                    if($i++ == 0) $str .= "<label for=\"input{$filed['name']}_{$k}\" class=\"control-label\">请选择{$filed['cnname']}</label>\n\n";
                    $str .= "<div class=\"checkbox\">\n<label>\n";
                    $str .= "<input type=\"checkbox\" name=\"{$filed['name']}[]\" id=\"input{$filed['name']}_{$k}\" value=\"{$k}\"";
                    if ($is_edit){
                        $str .= "<?php if(in_array($k, \$tmp_arr)) echo \" checked\";?>";
                    }
                    $str .= "> {$v}\n";
                    $str .= "</label>\n</div>\n";
                }
                $str .= "</div>\n";
                break;
            case 'radio':
                $str = "<div class=\"form-group\">\n";
                
                $i = 0;
                foreach ($filed['type_extend'] as $k=>$v){
                    if($i++ == 0) $str .= "<label for=\"input{$filed['name']}_{$k}\" class=\"control-label\">请选择{$filed['cnname']}</label>\n\n";
                    $str .= "<div class=\"radio\">\n<label>\n";
                    $str .= "<input type=\"radio\" name=\"{$filed['name']}\" id=\"input{$filed['name']}_{$k}\" value=\"{$k}\" ".($is_edit?"<?php if(\${$this->name}->{$filed['name']} == $k) echo 'checked';?>":"");
                    if($filed['required']){ $str .= " required";}
                    $str .= "> {$v}\n";
                    $str .= "</label>\n</div>\n";
                }
                $str .= "</div>\n";
                break;
            case 'select':
                $str = "<div class=\"form-group\">\n";
                $str .= "<label for=\"input{$filed['name']}\" class=\"control-label\">请选择{$filed['cnname']}</label>\n";
                $str .= "<select name=\"{$filed['name']}\" id=\"input{$filed['name']}\" class=\"form-control\" ".($filed['required']?"required":"").">\n";
                foreach ($filed['type_extend'] as $k=>$v){
                    $str .= "<option value=\"{$k}\" ".($is_edit?"<?php if(\${$this->name}->{$filed['name']} == $k) echo 'selected';?>":"").">{$v}</option>\n";
                }
                $str .= "</select>";
                $str .= "</div>\n";
                break;
            default:
                $str = "<div class=\"form-group\">\n";
                $str .= "<label name=\"{$filed['name']}\" for=\"input{$filed['name']}\" class=\"control-label\">{$filed['cnname']}</label>\n";
                $str .= "<input type=\"{$filed['type']}\" name=\"{$filed['name']}\" class=\"form-control\" id=\"input{$filed['name']}\" placeholder=\"{$filed['cnname']}\" value=\"<?php echo \${$this->name}->{$filed['name']};?>\"";
                if($filed['required']){ $str .= " required";}
                $str .= ">\n";
                $str .= "</div>\n";
                break;
        }
        
        return $str;
    }
    
    private function write($file, $string){
        self::mkdir(dirname($file));
        file_put_contents($file, $string);
        $mask = umask();
        chmod($file, 0777);
        umask($mask);
    }
    //递归生成目录
    private static function mkdir($dirname){
        return file_exists($dirname)||mkdir($dirname, 0777, true);
    }
    
    private function checkBoxCheck(){
        return "<script type=\"text/javascript\">
        $(':submit').click(function(){
            $('.form-group').each(function(){
                if($(':checkbox', this).length){
                    if($(':checkbox:checked', this).length<1){
                        $(':checkbox', this).get(0).setCustomValidity(\"请选择至少一项!\");
                    }else{
                        $(':checkbox',this).each(function(){this.setCustomValidity(\"\");});
                    }
                }
                var _this = this;
                $(':checkbox', this).click(function(){
                    if(this.checked){
                        $(':checkbox', _this).each(function(){this.setCustomValidity(\"\");});
                    }
                });
            });
        });
        </script>";
    }
    
}