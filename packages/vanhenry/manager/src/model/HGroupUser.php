<?php



namespace vanhenry\manager\model;



use Illuminate\Database\Eloquent\Model;



class HGroupUser extends Model

{

    public function hUsers(){

    	return $this->hasMany('vanhenry\manager\model\HUser','parent');

    }

    public function hGroupModules(){

    	return $this->belongsToMany('vanhenry\manager\model\HGroupModule','h_roles','group_user_id','group_module_id');

    }

    public function hRoles(){

    	return $this->hasMany('vanhenry\manager\model\HRole','group_user_id');

    }

    public function hActions(){
        return $this->belongsToMany(HAction::class,'h_group_user_h_action','h_group_user_id','h_action_id');
    }

}

