<?php
class link_model extends model{
    function AddLink($Values=array())
    {
        return $this->insert_into('admin_link',$Values);
    }
}
?>