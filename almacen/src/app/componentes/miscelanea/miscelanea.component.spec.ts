import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MiscelaneaComponent } from './miscelanea.component';

describe('MiscelaneaComponent', () => {
  let component: MiscelaneaComponent;
  let fixture: ComponentFixture<MiscelaneaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MiscelaneaComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MiscelaneaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
