/* global escodegen */

//<editor-fold defaultstate="collapsed" desc="ast">

var ast = {
	"type": "Program",
	"start": 0,
	"end": 64,
	"sourceType": "script",
	"interpreter": null,
	"body": [
		{
			"type": "ExpressionStatement",
			"start": 0,
			"end": 31,
			"expression": {
				"type": "CallExpression",
				"start": 0,
				"end": 30,
				"callee": {
					"type": "MemberExpression",
					"start": 0,
					"end": 28,
					"object": {
						"type": "NewExpression",
						"start": 1,
						"end": 15,
						"callee": {
							"type": "Identifier",
							"start": 5,
							"end": 6,
							"name": "M"
						},
						"arguments": [
							{
								"type": "ObjectExpression",
								"start": 7,
								"end": 14,
								"properties": [
									{
										"type": "Property",
										"start": 8,
										"end": 13,
										"method": false,
										"key": {
											"type": "Identifier",
											"start": 8,
											"end": 9,
											"name": "x"
										},
										"computed": false,
										"shorthand": false,
										"value": {
											"type": "Literal",
											"start": 11,
											"end": 13,
											"extra": {
												"rawValue": "",
												"raw": "''"
											},
											"value": ""
										}
									}
								]
							}
						],
						"extra": {
							"parenthesized": true,
							"parenStart": 0
						}
					},
					"property": {
						"type": "Identifier",
						"start": 27,
						"end": 28,
						"name": "y"
					},
					"computed": false
				},
				"arguments": []
			}
		},
		{
			"type": "ExpressionStatement",
			"start": 33,
			"end": 64,
			"expression": {
				"type": "CallExpression",
				"start": 33,
				"end": 63,
				"callee": {
					"type": "MemberExpression",
					"start": 33,
					"end": 61,
					"object": {
						"type": "NewExpression",
						"start": 34,
						"end": 48,
						"callee": {
							"type": "Identifier",
							"start": 38,
							"end": 39,
							"name": "M"
						},
						"arguments": [
							{
								"type": "ObjectExpression",
								"start": 40,
								"end": 47,
								"properties": [
									{
										"type": "Property",
										"start": 41,
										"end": 46,
										"method": false,
										"key": {
											"type": "Identifier",
											"start": 41,
											"end": 42,
											"name": "x"
										},
										"computed": false,
										"shorthand": false,
										"value": {
											"type": "Literal",
											"start": 44,
											"end": 46,
											"extra": {
												"rawValue": "",
												"raw": "''"
											},
											"value": ""
										}
									}
								]
							}
						],
						"extra": {
							"parenthesized": true,
							"parenStart": 33
						}
					},
					"property": {
						"type": "Identifier",
						"start": 60,
						"end": 61,
						"name": "x"
					},
					"computed": false
				},
				"arguments": []
			}
		}
	],
	"directives": []
};


var ast2 = {
  "type": "Program",
  "start": 0,
  "end": 218,
  "body": [
    {
      "type": "VariableDeclaration",
      "start": 0,
      "end": 12,
      "declarations": [
        {
          "type": "VariableDeclarator",
          "start": 4,
          "end": 11,
          "id": {
            "type": "Identifier",
            "start": 4,
            "end": 5,
            "name": "x"
          },
          "init": {
            "type": "Literal",
            "start": 8,
            "end": 11,
            "value": "y",
            "raw": "'y'"
          }
        }
      ],
      "kind": "var"
    },
    {
      "type": "VariableDeclaration",
      "start": 13,
      "end": 28,
      "declarations": [
        {
          "type": "VariableDeclarator",
          "start": 17,
          "end": 27,
          "id": {
            "type": "Identifier",
            "start": 17,
            "end": 18,
            "name": "k"
          },
          "init": {
            "type": "ObjectExpression",
            "start": 21,
            "end": 27,
            "properties": [
              {
                "type": "Property",
                "start": 22,
                "end": 26,
                "method": false,
                "shorthand": false,
                "computed": false,
                "key": {
                  "type": "Identifier",
                  "start": 22,
                  "end": 23,
                  "name": "z"
                },
                "value": {
                  "type": "Identifier",
                  "start": 25,
                  "end": 26,
                  "name": "M"
                },
                "kind": "init"
              }
            ]
          }
        }
      ],
      "kind": "var"
    },
    {
      "type": "VariableDeclaration",
      "start": 29,
      "end": 56,
      "declarations": [
        {
          "type": "VariableDeclarator",
          "start": 33,
          "end": 55,
          "id": {
            "type": "Identifier",
            "start": 33,
            "end": 35,
            "name": "oo"
          },
          "init": {
            "type": "ObjectExpression",
            "start": 38,
            "end": 55,
            "properties": [
              {
                "type": "Property",
                "start": 39,
                "end": 54,
                "method": false,
                "shorthand": false,
                "computed": false,
                "key": {
                  "type": "Identifier",
                  "start": 39,
                  "end": 40,
                  "name": "a"
                },
                "value": {
                  "type": "ObjectExpression",
                  "start": 41,
                  "end": 54,
                  "properties": [
                    {
                      "type": "Property",
                      "start": 42,
                      "end": 53,
                      "method": false,
                      "shorthand": false,
                      "computed": false,
                      "key": {
                        "type": "Identifier",
                        "start": 42,
                        "end": 43,
                        "name": "b"
                      },
                      "value": {
                        "type": "ObjectExpression",
                        "start": 44,
                        "end": 53,
                        "properties": [
                          {
                            "type": "Property",
                            "start": 45,
                            "end": 52,
                            "method": false,
                            "shorthand": false,
                            "computed": false,
                            "key": {
                              "type": "Identifier",
                              "start": 45,
                              "end": 46,
                              "name": "c"
                            },
                            "value": {
                              "type": "ObjectExpression",
                              "start": 47,
                              "end": 52,
                              "properties": [
                                {
                                  "type": "Property",
                                  "start": 48,
                                  "end": 51,
                                  "method": false,
                                  "shorthand": false,
                                  "computed": false,
                                  "key": {
                                    "type": "Identifier",
                                    "start": 48,
                                    "end": 49,
                                    "name": "d"
                                  },
                                  "value": {
                                    "type": "Identifier",
                                    "start": 50,
                                    "end": 51,
                                    "name": "k"
                                  },
                                  "kind": "init"
                                }
                              ]
                            },
                            "kind": "init"
                          }
                        ]
                      },
                      "kind": "init"
                    }
                  ]
                },
                "kind": "init"
              }
            ]
          }
        }
      ],
      "kind": "var"
    },
    {
      "type": "VariableDeclaration",
      "start": 57,
      "end": 69,
      "declarations": [
        {
          "type": "VariableDeclarator",
          "start": 61,
          "end": 68,
          "id": {
            "type": "Identifier",
            "start": 61,
            "end": 62,
            "name": "l"
          },
          "init": {
            "type": "Literal",
            "start": 65,
            "end": 68,
            "value": "z",
            "raw": "'z'"
          }
        }
      ],
      "kind": "var"
    },
    {
      "type": "VariableDeclaration",
      "start": 70,
      "end": 83,
      "declarations": [
        {
          "type": "VariableDeclarator",
          "start": 74,
          "end": 82,
          "id": {
            "type": "Identifier",
            "start": 74,
            "end": 75,
            "name": "r"
          },
          "init": {
            "type": "MemberExpression",
            "start": 78,
            "end": 82,
            "object": {
              "type": "Identifier",
              "start": 78,
              "end": 79,
              "name": "k"
            },
            "property": {
              "type": "Identifier",
              "start": 80,
              "end": 81,
              "name": "l"
            },
            "computed": true,
            "optional": false
          }
        }
      ],
      "kind": "var"
    },
    {
      "type": "ExpressionStatement",
      "start": 84,
      "end": 135,
      "expression": {
        "type": "CallExpression",
        "start": 84,
        "end": 134,
        "callee": {
          "type": "MemberExpression",
          "start": 84,
          "end": 132,
          "object": {
            "type": "NewExpression",
            "start": 86,
            "end": 127,
            "callee": {
              "type": "MemberExpression",
              "start": 90,
              "end": 102,
              "object": {
                "type": "MemberExpression",
                "start": 90,
                "end": 100,
                "object": {
                  "type": "MemberExpression",
                  "start": 90,
                  "end": 98,
                  "object": {
                    "type": "MemberExpression",
                    "start": 90,
                    "end": 96,
                    "object": {
                      "type": "MemberExpression",
                      "start": 90,
                      "end": 94,
                      "object": {
                        "type": "Identifier",
                        "start": 90,
                        "end": 92,
                        "name": "oo"
                      },
                      "property": {
                        "type": "Identifier",
                        "start": 93,
                        "end": 94,
                        "name": "a"
                      },
                      "computed": false,
                      "optional": false
                    },
                    "property": {
                      "type": "Identifier",
                      "start": 95,
                      "end": 96,
                      "name": "b"
                    },
                    "computed": false,
                    "optional": false
                  },
                  "property": {
                    "type": "Identifier",
                    "start": 97,
                    "end": 98,
                    "name": "c"
                  },
                  "computed": false,
                  "optional": false
                },
                "property": {
                  "type": "Identifier",
                  "start": 99,
                  "end": 100,
                  "name": "d"
                },
                "computed": false,
                "optional": false
              },
              "property": {
                "type": "Identifier",
                "start": 101,
                "end": 102,
                "name": "z"
              },
              "computed": false,
              "optional": false
            },
            "arguments": [
              {
                "type": "ObjectExpression",
                "start": 103,
                "end": 126,
                "properties": [
                  {
                    "type": "Property",
                    "start": 104,
                    "end": 125,
                    "method": false,
                    "shorthand": false,
                    "computed": false,
                    "key": {
                      "type": "Identifier",
                      "start": 104,
                      "end": 118,
                      "name": "yktjgtktgyjtgy"
                    },
                    "value": {
                      "type": "Literal",
                      "start": 120,
                      "end": 125,
                      "value": "...",
                      "raw": "'...'"
                    },
                    "kind": "init"
                  }
                ]
              }
            ]
          },
          "property": {
            "type": "Identifier",
            "start": 130,
            "end": 131,
            "name": "x"
          },
          "computed": true,
          "optional": false
        },
        "arguments": [],
        "optional": false
      }
    },
    {
      "type": "ExpressionStatement",
      "start": 136,
      "end": 176,
      "expression": {
        "type": "CallExpression",
        "start": 136,
        "end": 175,
        "callee": {
          "type": "MemberExpression",
          "start": 136,
          "end": 173,
          "object": {
            "type": "NewExpression",
            "start": 138,
            "end": 168,
            "callee": {
              "type": "Identifier",
              "start": 142,
              "end": 143,
              "name": "r"
            },
            "arguments": [
              {
                "type": "ObjectExpression",
                "start": 144,
                "end": 167,
                "properties": [
                  {
                    "type": "Property",
                    "start": 145,
                    "end": 166,
                    "method": false,
                    "shorthand": false,
                    "computed": false,
                    "key": {
                      "type": "Identifier",
                      "start": 145,
                      "end": 159,
                      "name": "yktjgtktgyjtgy"
                    },
                    "value": {
                      "type": "Literal",
                      "start": 161,
                      "end": 166,
                      "value": "...",
                      "raw": "'...'"
                    },
                    "kind": "init"
                  }
                ]
              }
            ]
          },
          "property": {
            "type": "Identifier",
            "start": 171,
            "end": 172,
            "name": "x"
          },
          "computed": true,
          "optional": false
        },
        "arguments": [],
        "optional": false
      }
    },
    {
      "type": "ExpressionStatement",
      "start": 177,
      "end": 203,
      "expression": {
        "type": "CallExpression",
        "start": 177,
        "end": 202,
        "callee": {
          "type": "MemberExpression",
          "start": 177,
          "end": 200,
          "object": {
            "type": "NewExpression",
            "start": 179,
            "end": 196,
            "callee": {
              "type": "Identifier",
              "start": 183,
              "end": 184,
              "name": "M"
            },
            "arguments": [
              {
                "type": "ObjectExpression",
                "start": 185,
                "end": 195,
                "properties": [
                  {
                    "type": "Property",
                    "start": 186,
                    "end": 194,
                    "method": false,
                    "shorthand": false,
                    "computed": false,
                    "key": {
                      "type": "Identifier",
                      "start": 186,
                      "end": 187,
                      "name": "x"
                    },
                    "value": {
                      "type": "Literal",
                      "start": 189,
                      "end": 194,
                      "value": "...",
                      "raw": "'...'"
                    },
                    "kind": "init"
                  }
                ]
              }
            ]
          },
          "property": {
            "type": "Identifier",
            "start": 199,
            "end": 200,
            "name": "y"
          },
          "computed": false,
          "optional": false
        },
        "arguments": [],
        "optional": false
      }
    },
    {
      "type": "ExpressionStatement",
      "start": 204,
      "end": 211,
      "expression": {
        "type": "CallExpression",
        "start": 204,
        "end": 210,
        "callee": {
          "type": "MemberExpression",
          "start": 204,
          "end": 208,
          "object": {
            "type": "Identifier",
            "start": 204,
            "end": 205,
            "name": "M"
          },
          "property": {
            "type": "Identifier",
            "start": 206,
            "end": 207,
            "name": "x"
          },
          "computed": true,
          "optional": false
        },
        "arguments": [],
        "optional": false
      }
    },
    {
      "type": "ExpressionStatement",
      "start": 212,
      "end": 218,
      "expression": {
        "type": "CallExpression",
        "start": 212,
        "end": 217,
        "callee": {
          "type": "MemberExpression",
          "start": 212,
          "end": 215,
          "object": {
            "type": "Identifier",
            "start": 212,
            "end": 213,
            "name": "M"
          },
          "property": {
            "type": "Identifier",
            "start": 214,
            "end": 215,
            "name": "y"
          },
          "computed": false,
          "optional": false
        },
        "arguments": [],
        "optional": false
      }
    }
  ],
  "sourceType": "module"
};

//</editor-fold>




/**  
 * Функция обхода дерева. Выполняет обход дерева в глубину,  
 * передаваяв callback-функции onNodeEnter (до посещения потомков)  
 * и onNodeLeave (после посещения потомков) каждый узел дерева  
 * и текущую область видимости (смотри определение Scope ниже)  
 *  
 * @param      {object}    ast                              Исходное ast  
 * @param      {Function}  [onNodeEnter=(node, scope)=>{}]  Вызывается для каждого узла до посещения потомков  
 * @param      {Function}  [onNodeLeave=(node, scope)=>{}]  Вызывается для каждого узла после посещения потомков  
 */  
function traverse(  
    ast,  
    onNodeEnter = (node, scope) => {},  
    onNodeLeave = (node, scope) => {}  
) {  
    const rootScope = new Scope(ast);  
 
    _inner(ast, rootScope);  
 
    /**  
     * Определение области видимости узла.  
     * Может либо вернуть текущий scope, либо создать новый  
     *  
     * @param      {object}  astNode       ast-узел  
     * @param      {Scope}   currentScope  текущая область видимости  
     * @return     {Scope}   область видимости для внутренних узлов astNode  
     */  
    function resolveScope(astNode, currentScope) {
        let isFunctionExpression = ast.type === 'FunctionExpression',  
            isFunctionDeclaration = ast.type === 'FunctionDeclaration';  
 
        if (!isFunctionExpression &&  
            !isFunctionDeclaration) {  
            // Новые области видимости порждают только функции  
            return currentScope;  
        }  
 
        // каждая функция порождает новую область видимости  
        const newScope = new Scope(ast, currentScope);  
 
        ast.params.forEach(param => {
            // параметры функции доступны внутри функции
            newScope.add(param.name);
        });  
 
        if (isFunctionDeclaration) {  
            // имя функции при декларации доступно снаружи функции  
            currentScope.add(ast.id.name);  
        } else {  
            // имя функции-выражения доступно только внутри неё  
            newScope.add(ast.id.name);  
        }

        return newScope;
    }
 
    /**  
     * Рекурсивная функция обхода ast  
     *  
     * @param      {object}  astNode  Текущий ast-узел  
     * @param      {Scope}  scope     Область видимости для текущего ast-узла  
     */  
    function _inner(astNode, scope) {  
        if (Array.isArray(astNode)) {  
            astNode.forEach(node => {  
                /* Рекурсивный обход элементов списков.  
                 * Списками являются, например, параметры функций  
                 */  
                _inner(node, scope);  
            });  
        } else if (astNode && typeof astNode === 'object') {  
            onNodeEnter(astNode, scope);  
 
            const innerScope = resolveScope(astNode, scope),  
                keys = Object.keys(astNode).filter(key => {  
                    // loc - служебное свойство, а не ast-узел  
                    return key !== 'loc' &&  
                        astNode[key] && typeof astNode[key] === 'object';  
                });  
 
            keys.forEach(key => {  
                // Обход всех потомков  
                _inner(astNode[key], innerScope);  
            });  
 
            onNodeLeave(astNode, scope);  
        }  
    }  
}  
 
/**  
 * Представление области видимости  
 *  
 * @class      Scope (name)  
 * @param      {object}  astNode      ast-узел, породивший эту область видимости  
 * @param      {object}  parentScope  Родительская область видимости  
 */  
function Scope(astNode, parentScope) {  
    this._node = astNode;  
    this._parent = parentScope;  
    this._vars = new Set();  
}  
 
Scope.prototype = {  
    /**  
     * Добавление имени переменной в область видимости  
     *  
     * @param      {string}  name    имя переменной  
     */  
    add(name) {  
        this._vars.add(name);  
    },  
    /**  
     * Была ли определена переменная с таким именем.  
     *  
     * @param      {string}   name    имя переменной  
     * @return     {boolean}  Встречалась ли переменная с таким именем в доступных областях видимости  
     */  
    isDefined(name) {  
        return this._vars.has(name) || (this._parent && this._parent.isDefined(name));  
    }  
};  


var y_aliases = {y:1};
var M_aliases = {M:1};
function onNodeEnter(node, scope) {
	var type = node.type;
	var toLogTypes = [
		'VariableDeclarator',
		'NewExpression',
	];

	if (node.type === 'VariableDeclarator'){
		if (node.init.type === 'Literal' && node.init.value === 'y') {
			y_aliases[node.id.name] = 1;
		}
		
	} else if (node.type === 'NewExpression') {
		
	}
}
function onNodeLeave(node, scope) {
	
}
function logArgs(node, scope) {

	
}
traverse(ast2, onNodeEnter, onNodeLeave);
console.log(y_aliases, M_aliases);



console.log(escodegen.generate(ast2));