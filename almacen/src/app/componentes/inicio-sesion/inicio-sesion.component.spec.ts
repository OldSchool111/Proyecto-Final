import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InicioSesionComponentComponent } from './inicio-sesion.component';

describe('InicioSesionComponent', () => {
  let component: InicioSesionComponentComponent;
  let fixture: ComponentFixture<InicioSesionComponentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [InicioSesionComponentComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(InicioSesionComponentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
