<?php

namespace App\Core\Services;


use App\Core\Facades\DB;
use App\Core\library\Rules;
use App\Models\User;
use Exception;

class ValidationService
{
    use Rules;

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $data
     * @param array $rules
     * @param array|null $errors
     * @return $this
     * @throws Exception
     */
    public function make(array $data, array $rules, array|null $errors = null): static|bool
    {

        if (empty($data)){
            foreach($rules as $ruleName => $ruleset){
                $data[$ruleName] = '';
            }
        }


        foreach ($rules as $ruleName => $ruleset) {
            foreach ($data as $key => $value) {
                $this->oldValues[$key] = $value;
                if ($key == $ruleName) {

                    foreach (explode('|', $ruleset) as $rule) {
                        $ruleParam = '';
                        if (strpos($rule, ':')) {
                            $ruleParam = substr($rule, strpos($rule, ':') + 1);
                            $rule = substr($rule, 0, strpos($rule, ':'));
                        }

                        $args = empty($ruleParam) ? ['key' => $key, 'value' => $value] : ['key' => $key, 'value' => $value, 'param' => $ruleParam];

                            if(!method_exists($this,$rule))
                                throw_exception("Validation Rule $rule Doesnt Exists ");

                        call_user_func_array([$this, $rule], [$args]);
                    }
                }


            }

        }

        return  $this;
    }
}