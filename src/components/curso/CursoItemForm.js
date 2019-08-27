import React from 'react';
import { Form, Button, Header, Dropdown } from 'semantic-ui-react';


export const CursoItemForm = ({ curso,
    titulo, onClickAction, changeAction, categorias }) =>
    <Form encType="multipart/form-data">
        <Header>{titulo}</Header>
        <Form.Field>
            <label>Título</label>
            <input placeholder='Título'
                name="titulo"
                type="text"
                value={curso.titulo}
                onChange={changeAction} />
        </Form.Field>
        <Form.Field>
            <label>Categoria</label>
            <Dropdown name="categoria_id" onChange={changeAction} value={curso.categoria_id} clearable options={categorias} selection />
        </Form.Field>
        <Form.Field>
            <label>Nome Tutor</label>
            <input placeholder='Nome do Tutor'
                name="nomeTutor"
                type="text"
                onChange={changeAction}
                value={curso.nomeTutor} />
        </Form.Field>
        <label>&nbsp;</label>
        <Button floated="right" onClick={() => onClickAction('AE')} icon="check" basic></Button>
        <label>&nbsp;</label>
        {
            titulo.includes('Edição') ?
                <Button onClick={() => onClickAction('R')} icon="close" basic></Button> : ''
        }
    </Form>