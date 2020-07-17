import React from 'react'
import Accordion from 'react-bootstrap/Accordion';
import Card from 'react-bootstrap/Card';
import Container from 'react-bootstrap/Container';
import * as uuid from 'uuid';

export default function Lists(props) {
    return (
        <Card style={{border:"1px #CCCCCC solid", borderRadius:4, padding:5, marginBottom:5}}>
            <Accordion.Toggle  as={Card.Header} eventKey="0">
                {props.data.vehicle === "flight" ? <i className="fa fa-plane" style={{marginLeft: 10, marginRight:10}}></i> : (props.data.vehicle === "Train" ? <i className="fa fa-train" style={{marginLeft: 10, marginRight:10}}></i>:<i className="fa fa-bus" style={{marginLeft: 10, marginRight:10}}></i>)}{props.data.vehicle_key}
                <strong style={{marginLeft: 30}}>From: </strong>
                <span>{props.data.from}</span>
                <strong style={{marginLeft: 30}}>Destination: </strong>
                <span>{props.data.to}</span>
                <strong style={{marginLeft: 30}}>Détails: </strong>
                <span>{props.data.vehicle_Detail}</span>
            </Accordion.Toggle>
            <Accordion.Collapse eventKey="0">
            <Card.Body>
                <Container>
                    <p><i className="fa fa-suitcase"></i> {props.data.bagage_description === "none" || props.data.bagage_description === "" ? "No bags description" : props.data.bagage_description }</p>
                    <p><i className="fa fa-wheelchair-alt"></i> {props.data.seat === "none" || props.data.seat === "" ? "No seat assignment" : props.data.seat }</p>
                </Container>
            </Card.Body>
            </Accordion.Collapse>
        </Card>
            
    )
}
